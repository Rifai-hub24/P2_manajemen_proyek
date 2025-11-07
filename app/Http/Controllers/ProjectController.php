<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\ProjectMember;
use App\Models\Board;
use Carbon\Carbon;

class ProjectController extends Controller
{
    /**
     * Dashboard utama (redirect sesuai role user)
     */
   public function index()
{
    $role = auth()->user()->role;

    switch ($role) {
        case 'admin':
            $userId = auth()->id();

    // 🔹 Hanya ambil project yang ada user login sebagai admin di project_members
    $query = Project::whereHas('members', function ($q) use ($userId) {
        $q->where('user_id', $userId)
          ->where('role', 'admin');
    })
    ->with('boards', 'members.user');

    // 🔍 Filter pencarian nama proyek
    if (request()->filled('search')) {
        $query->where('project_name', 'like', '%' . request()->search . '%');
    }
    // 🔍 Filter tanggal (baru dan akurat)
    if (request()->filled('start_date') && request()->filled('end_date')) {
        $start = \Carbon\Carbon::parse(request('start_date'))->startOfDay(); // jam 00:00:00
        $end   = \Carbon\Carbon::parse(request('end_date'))->endOfDay();     // jam 23:59:59

        $query->whereBetween('created_at', [$start, $end]);
    }


    // 🔽 Urutkan: yang belum approved di atas, approved di bawah
    $query->orderByRaw("
        CASE 
            WHEN status = 'approved' THEN 2
            ELSE 1
        END
    ")->orderBy('created_at', 'desc');

    $projects = $query->get();
    return view('admin.dashboard', compact('projects'));

        case 'team_lead':
            return $this->teamLeadDashboard();

        case 'developer':
            return $this->developerDashboard();

        case 'designer':
            return $this->designerDashboard();

        default:
            abort(403, 'Role tidak dikenal');
    }
}


    /**
     * ================= ADMIN =================
     */

    // Form buat proyek
    public function create()
    {
        if (auth()->user()->role !== 'admin') abort(403);
        return view('admin.projects.create');
    }

    // Simpan proyek baru
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $request->validate([
            'project_name' => 'required|string|max:255',
            'description'  => 'nullable|string',
            'deadline'     => 'nullable|date',
        ]);

        // Simpan proyek
        $project = Project::create([
            'project_name' => $request->project_name,
            'description'  => $request->description,
            'created_by'   => auth()->id(),
            'deadline'     => $request->deadline
        ]);

        // Masukkan Admin ke project_members
        ProjectMember::create([
            'project_id' => $project->project_id,
            'user_id'    => auth()->id(),
            'role'       => 'admin',
        ]);

        // Buat boards default
        $boards = ['To Do', 'In Progress', 'Review', 'Done'];
        foreach ($boards as $i => $board) {
            Board::create([
                'project_id' => $project->project_id,
                'board_name' => $board,
                'position'   => $i + 1
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Project berhasil dibuat!');
    }
    public function show(Project $project)
    {
         // Eager-load sampai subtasks supaya hanya 1 query besar
         $project = Project::with(['boards.cards.subtasks', 'members.user'])
                 ->findOrFail($project->project_id);

        // Flatten untuk dapat semua subtasks sebagai collection
        $subtasks = $project->boards
                        ->pluck('cards')   // collection of card collections
                        ->flatten()
                        ->pluck('subtasks') // collection of subtask collections
                        ->flatten();

        $hasStarted = $subtasks->where('status', 'in_progress')->isNotEmpty();
        $hasDone    = $subtasks->where('status', 'done')->isNotEmpty();

       return view('admin.projects.show', compact('project', 'hasStarted', 'hasDone'));
  }
    /**
     * ================= TEAM LEAD =================
     */

    // Dashboard Team Lead
    public function teamLeadDashboard()
    {
        $userId = auth()->id();

        $projects = Project::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with('boards', 'members.user')->get();

        return view('teamlead.dashboard', compact('projects'));
    }

    // Detail proyek Team Lead
    public function teamLeadShow(Project $project)
    {
        $userId = auth()->id();

        $project = Project::where('project_id', $project->project_id)
            ->whereHas('members', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->with('boards.cards', 'members.user')
            ->firstOrFail();

        return view('teamlead.projects.show', compact('project'));
    }

    /**
     * ================= DEVELOPER =================
     */
   public function developerDashboard()
{
    $userId = auth()->id();

    // ambil semua cards yang di-assign ke developer ini
    $cards = \App\Models\Card::whereHas('assignments', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['board.project']) // supaya bisa tahu project dan board
        ->get()
        ->sortBy(function($card) {
            // Urutan status project: yang belum approved lebih atas
            $statusOrder = [
                'draft'    => 1,
                'pending'  => 1,
                'rejected' => 1,
                'approved' => 2,
            ];

            return [
                $statusOrder[$card->board->project->status] ?? 99, // default ke bawah
                $card->board->position ?? 0,
                $card->position ?? 0,
            ];
        })
        ->values(); // reset index array

    return view('developer.dashboard', compact('cards'));
}



    /**
     * ================= DESIGNER =================
     */
     public function designerDashboard()
{
    $userId = auth()->id();

    $cards = \App\Models\Card::whereHas('assignments', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->with(['board.project'])
        ->get()
        ->sortBy(function($card) {
            // urutkan project yang belum approved di atas
            $statusOrder = [
                'draft'    => 1,
                'pending'  => 1,
                'rejected' => 1,
                'approved' => 2,
            ];

            return [
                $statusOrder[$card->board->project->status] ?? 99,
                $card->board->position ?? 0,
                $card->position ?? 0,
            ];
        })
        ->values();

    return view('designer.dashboard', compact('cards'));
}
public function submit($projectId)
{
    $project = Project::findOrFail($projectId);

    if (auth()->user()->role !== 'team_lead') {
        abort(403, 'Hanya Team Lead yang bisa mengirim project.');
    }

    // hanya boleh kirim kalau status draft atau rejected
    if (!in_array($project->status, ['draft', 'rejected'])) {
        return back()->with('error', '⚠️ Proyek sudah pernah dikirim.');
    }

    $project->status = 'pending';
    $project->rejection_reason = null; // reset alasan reject saat dikirim ulang
    $project->save();

    return back()->with('success', "📤 Proyek {$project->project_name} sudah dikirim ke Admin untuk approval.");
}

public function approve($projectId)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Hanya admin yang bisa approve project.');
    }

    $project = Project::with('members.user')->findOrFail($projectId);

    if ($project->status !== 'pending') {
        return back()->with('error', '⚠️ Hanya proyek pending yang bisa di-approve.');
    }

    $project->status = 'approved';
    $project->save();

    foreach ($project->members as $member) {
        $member->user->update(['current_task_status' => 'idle']);
    }

    return back()->with('success', "✅ Proyek {$project->project_name} disetujui.");
}

public function reject(Request $request, $projectId)
{
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Hanya admin yang bisa reject project.');
    }

    $request->validate([
        'reason' => 'required|string|max:500'
    ]);

    $project = Project::with('members.user')->findOrFail($projectId);

    if ($project->status !== 'pending') {
        return back()->with('error', '⚠️ Hanya proyek pending yang bisa di-reject.');
    }

    // ✅ ubah status jadi rejected, bukan draft
    $project->status = 'rejected';
    $project->rejection_reason = $request->reason;
    $project->save();

    foreach ($project->members as $member) {
        $member->user->update(['current_task_status' => 'working']);
    }

    return back()->with('error', "❌ Proyek {$project->project_name} ditolak. Alasan: {$request->reason}");
}
// Edit form
public function edit(Project $project)
{
    if (auth()->user()->role !== 'admin') abort(403);

    if ($project->status === 'approved') {
        return redirect()->route('dashboard')->with('error', '❌ Project sudah approved, tidak bisa diedit.');
    }

    return view('admin.projects.edit', compact('project'));
}

// Update project
public function update(Request $request, Project $project)
{
    if (auth()->user()->role !== 'admin') abort(403);

    if ($project->status === 'approved') {
        return redirect()->route('dashboard')->with('error', '❌ Project sudah approved, tidak bisa diedit.');
    }

    $request->validate([
        'project_name' => 'required|string|max:255',
        'description'  => 'nullable|string',
        'deadline'     => 'nullable|date',
    ]);
    // ✅ Cek apakah user mengubah deadline
    if ($request->filled('deadline')) {
        // Jika user isi deadline baru → validasi tidak boleh sebelum hari ini
        $request->validate([
            'deadline' => 'after_or_equal:today',
        ]);
        $deadline = $request->deadline;
    } else {
        // Jika tidak diubah → gunakan deadline lama
        $deadline = $project->deadline;
    }

    $project->update([
        'project_name' => $request->project_name,
        'description'  => $request->description,
        'deadline'     => $request->deadline,
    ]);

    return redirect()->route('dashboard')->with('success', "✅ Proyek {$project->project_name} berhasil diperbarui.");
}

// Delete project

public function destroy(Project $project)
{
    if (auth()->user()->role !== 'admin') abort(403);

    if ($project->status === 'approved') {
        return redirect()->route('dashboard')->with('error', '❌ Project sudah approved, tidak bisa dihapus.');
    }

    $projectName = $project->project_name;

    // 🔹 Ambil semua member beserta user
    $members = $project->members()->with('user')->get();

    // 🔹 Reset status user ke idle (kecuali admin)
    foreach ($members as $member) {
        if ($member->user && $member->user->role !== 'admin') {
            $member->user->update(['current_task_status' => 'idle']);
        }
    }

    // 🔹 Hapus boards & members
    $project->boards()->delete();
    $project->members()->delete();

    // 🔹 Hapus project
    $project->delete();

    return redirect()->route('dashboard')
        ->with('success', "🗑️ Proyek {$projectName} berhasil dihapus, semua anggota non-admin dikembalikan ke status idle.");
}

}
