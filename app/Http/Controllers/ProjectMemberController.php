<?php

namespace App\Http\Controllers;

use App\Models\ProjectMember;
use App\Models\Project;
use App\Models\User;
use App\Models\Subtask;
use App\Models\Card;
use App\Models\CardAssignment;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    /**
     * Tambahkan anggota baru ke proyek
     */
    public function addMember(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        if ($project->status === 'approved') {
            return back()->with('error', '❌ Project sudah approved, tidak bisa menambah anggota.');
        }

        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return back()->with('error', '❌ User tidak ditemukan!');
        }
       
        // ✅ Batasi role yang boleh gabung ke project
        $allowedRoles = ['admin','team_lead','developer','designer'];
        if (!in_array($user->role, $allowedRoles)) {
           return back()->with('error', '🚫 Role user tidak valid untuk bergabung ke project.');
        }
        
        // ✅ Cek kalau project sudah ada admin
        if ($user->role === 'admin' && $project->members->where('role','admin')->count() > 0) {
           return back()->with('error', '⚠️ Project ini sudah memiliki seorang Admin.');
        }

        // Kalau user bukan admin dan statusnya sudah working → tolak
        if ($user->role !== 'admin' && $user->current_task_status === 'working') {
            return back()->with('error', '⚠️ User sedang bekerja di project lain, tunggu sampai project di-approve admin!');
        }

        // Tambahkan user ke project
        ProjectMember::create([
            'project_id' => $projectId,
            'user_id'    => $user->user_id,
            'role'       => $user->role === 'admin' ? 'admin' : 'member',
            'joined_at'  => now(),
        ]);

        // Update status user jadi working (kecuali admin)
        if ($user->role !== 'admin') {
            $user->update(['current_task_status' => 'working']);
        }

        return back()->with('success', '✅ Anggota berhasil ditambahkan ke project!');
    }
     /**
     * Update User
     */
    public function updateUser(Request $request, $memberId)
{
    $member = ProjectMember::with('project')->findOrFail($memberId);
    
    // ❌ Cek jika ada subtask in_progress di project ini
    $hasStarted = Subtask::whereHas('card.board', function($q) use ($member) {
        $q->where('project_id', $member->project->project_id);
    })->where('status', 'in_progress')->exists();

    if ($hasStarted) {
        return back()->with('error', '⚠️ Tidak bisa edit anggota, subtask sudah berjalan.');
    }

    if ($member->project->status === 'approved') {
        return back()->with('error', '❌ Project sudah approved, tidak bisa edit anggota.');
    }

    $request->validate([
        'username' => 'required|string|exists:users,username'
    ]);

    $newUser = User::where('username', $request->username)->first();

    if (!$newUser) {
        return back()->with('error', '❌ User tidak ditemukan.');
    }
   
    // ✅ Batasi role yang boleh gabung ke project
    $allowedRoles = ['admin','team_lead','developer','designer'];
    if (!in_array($newUser->role, $allowedRoles)) {
        return back()->with('error', '🚫 Role user tidak valid untuk bergabung ke project.');
    }
    
    // ✅ Jika user baru admin → pastikan project belum ada admin (kecuali member yang diganti admin juga)
    if ($newUser->role === 'admin' && $member->project->members->where('role','admin')->where('member_id','!=',$member->member_id)->count() > 0) {
        return back()->with('error', '⚠️ Project ini sudah memiliki Admin.');
    }

    // Pastikan user baru bukan sedang working di project lain
    if ($newUser->role !== 'admin' && $newUser->current_task_status === 'working') {
        return back()->with('error', '⚠️ User sedang bekerja di project lain.');
    }
    // 🔥 Hapus semua card milik user lama di project ini
        $cards = Card::whereHas('board', function($q) use ($member) {
                $q->where('project_id', $member->project->project_id);
            })
            ->whereHas('assignments', function($q) use ($member) {
                $q->where('user_id', $member->user->user_id);
            })->get();

        foreach ($cards as $card) {
            CardAssignment::where('card_id', $card->card_id)->delete();
            $card->delete();
        }

    // Reset status user lama jadi idle (kecuali admin)
    if ($member->user->role !== 'admin') {
        $member->user->update(['current_task_status' => 'idle']);
    }

    // Update user_id ke user baru
    $member->update([
        'user_id' => $newUser->user_id,
        'role'    => $newUser->role === 'admin' ? 'admin' : 'member',
    ]);

    // Update status user baru jadi working (kecuali admin)
    if ($newUser->role !== 'admin') {
        $newUser->update(['current_task_status' => 'working']);
    }

    return back()->with('success', '✅ Anggota berhasil diganti!');
}


    /**
     * Hapus anggota
     */
    public function deleteMember($memberId)
    {
        $member = ProjectMember::with(['project', 'user'])->findOrFail($memberId);
        // ❌ Cek jika ada subtask in_progress di project ini
        $hasStarted = Subtask::whereHas('card.board', function($q) use ($member) {
            $q->where('project_id', $member->project->project_id);
        })->where('status', 'in_progress')->exists();

        if ($hasStarted) {
            return back()->with('error', '⚠️ Tidak bisa hapus anggota, subtask sudah berjalan.');
       }

        if ($member->project->status === 'approved') {
            return back()->with('error', '❌ Project sudah approved, tidak bisa hapus anggota.');
        }
        // 🔥 Hapus semua card milik user ini dalam project
        $cards = Card::whereHas('board', function($q) use ($member) {
                $q->where('project_id', $member->project->project_id);
            })
            ->whereHas('assignments', function($q) use ($member) {
                $q->where('user_id', $member->user->user_id);
            })->get();

        foreach ($cards as $card) {
            CardAssignment::where('card_id', $card->card_id)->delete();
            $card->delete();
        }

        // reset status user jadi idle kalau bukan admin
        if ($member->user->role !== 'admin') {
            $member->user->update(['current_task_status' => 'idle']);
        }

        $member->delete();

        return back()->with('success', '🗑️ Anggota berhasil dihapus!');
    }
    public function myTeam()
{
    $user = auth()->user();

    // Cari project yang diikuti user ini
    $projects = Project::whereHas('members', function($q) use ($user) {
        $q->where('user_id', $user->user_id);
    })->with(['members.user'])->get();

    return view('teamlead.myteam', compact('projects', 'user'));
}

public function developerTeam()
{
    $user = auth()->user();

    // Cari semua project yang diikuti developer ini
    $projects = Project::whereHas('members', function($q) use ($user) {
        $q->where('user_id', $user->user_id);
    })->with(['members.user', 'members'])->get();

    // Jika semua project sudah approved → anggap belum ada project aktif
    $hasApprovedOnly = $projects->every(fn($p) => $p->status === 'approved');

    return view('developer.myteam', compact('projects', 'user', 'hasApprovedOnly'));
}
public function designerTeam()
{
    $user = auth()->user();

    // Cari semua project yang diikuti designer ini
    $projects = Project::whereHas('members', function($q) use ($user) {
        $q->where('user_id', $user->user_id);
    })->with(['members.user', 'members'])->get();

    // Jika semua project sudah approved → anggap belum ada project aktif
    $hasApprovedOnly = $projects->every(fn($p) => $p->status === 'approved');

    return view('designer.myteam', compact('projects', 'user', 'hasApprovedOnly'));
}

}
