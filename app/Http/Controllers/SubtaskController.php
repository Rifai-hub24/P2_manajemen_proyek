<?php

namespace App\Http\Controllers;

use App\Models\Subtask;
use App\Models\Card;
use App\Models\TimeLog;
use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubtaskController extends Controller
{
    private function updateCardActualHours($cardId)
    {
        $card = Card::with('subtasks')->find($cardId);
        if ($card) {
            $totalActual = $card->subtasks->sum('actual_hours'); // jumlahkan semua actual_hours subtasks
            $card->actual_hours = $totalActual;
            $card->save();
        }
    }
    /**
     * 🔹 Fungsi tambahan: update status Card otomatis
     */
    private function updateCardStatus($card)
    {
        $total = $card->subtasks()->count();
        $done = $card->subtasks()->where('status', 'done')->count();

        if ($total === 0) {
            $card->update(['status' => 'todo']);
            return;
        }

        if ($done === $total) {
            $doneBoard = Board::where('project_id', $card->board->project_id ?? null)
                ->where('board_name', 'Done')
                ->first();
            if ($doneBoard) {
                $card->update(['status' => 'done', 'board_id' => $doneBoard->board_id]);
            } else {
                $card->update(['status' => 'done']);
            }
            return;
        }

        if ($card->subtasks()->where('status', 'in_progress')->exists()) {
            $inProgressBoard = Board::where('project_id', $card->board->project_id ?? null)
                ->where('board_name', 'In Progress')
                ->first();
            if ($inProgressBoard) {
                $card->update(['status' => 'in_progress', 'board_id' => $inProgressBoard->board_id]);
            } else {
                $card->update(['status' => 'in_progress']);
            }
            return;
        }

        if ($card->subtasks()->where('status', 'todo')->count() === $total) {
            $card->update(['status' => 'todo']);
            return;
        }

        $reviewBoard = Board::where('project_id', $card->board->project_id ?? null)
            ->where('board_name', 'Review')
            ->first();
        if ($reviewBoard) {
            $card->update(['status' => 'review', 'board_id' => $reviewBoard->board_id]);
        } else {
            $card->update(['status' => 'review']);
        }
    }
    
    /**
     * Show form create subtask
     */
    public function create(Card $card)
    {
        $role = Auth::user()->role;

         // 🔒 Cegah buat subtask kalau project sudah approved
         if ($card->board->project->status === 'approved') {
            return back()->with('error', '❌ Project sudah approved, tidak bisa menambahkan subtask.');
            }

        if ($role === 'developer') {
            return view('developer.subtasks.create', compact('card'));
        }

        if ($role === 'designer') {
            return view('designer.subtasks.create', compact('card'));
        }

        abort(403, 'Role tidak diizinkan');
    }

    /**
     * Store new subtask
     */
   public function store(Request $request, Card $card)
{
     if ($card->board->project->status === 'approved') {
        return back()->with('error', '❌ Project sudah approved, tidak bisa menambahkan subtask.');
    }
    $request->validate([
        'subtask_title'   => 'required|string|max:150',
        'description'     => 'nullable|string',
        'estimated_hours' => 'nullable|numeric|min:0',
        'position'        => 'nullable|integer|min:1',
    ]);

    Subtask::create([
        'card_id'        => $card->card_id,
        'subtask_title'  => $request->subtask_title,
        'description'    => $request->description,
        'estimated_hours'=> $request->estimated_hours,
        'actual_hours'   => 0,
        'status'         => 'todo',
        'position'       => $request->position ?? 1,
        'created_at'     => Carbon::now('Asia/Jakarta'),
    ]);
    $this->updateCardStatus($card);

   
    $role = strtolower(Auth::user()->role);

    if ($role === 'developer') {
        return redirect()->route('developer.dashboard')
            ->with('success', '✅ Subtask berhasil ditambahkan!');
    }

    if ($role === 'designer') {
        return redirect()->route('designer.dashboard')
            ->with('success', '✅ Subtask berhasil ditambahkan!');
    }

   // Jika bukan developer atau designer, kembalikan ke halaman sebelumnya
   return back()->with('error', '❌ Hanya developer dan designer yang dapat menambahkan subtask.');
  }


    /**
     * Form edit subtask
     */
    public function edit(Subtask $subtask)
{
    // 🔒 Cegah edit jika project sudah approved
    if ($subtask->card->board->project->status === 'approved') {
        return back()->with('error', '❌ Project sudah approved, tidak bisa edit subtask.');
    }
    if ($subtask->status === 'in_progress') {
        return back()->with('error', '❌ Subtask sedang dikerjakan, tidak bisa diedit');
    }

    $role = strtolower(trim(Auth::user()->role)); // normalisasi role
    $card = $subtask->card;

    if ($role === 'developer') {
        return view('developer.subtasks.edit', compact('subtask', 'card'));
    }

    if ($role === 'designer') {
        return view('designer.subtasks.edit', compact('subtask', 'card'));
    }

    abort(403, 'Akses ditolak: Role tidak sesuai');
}


   public function update(Request $request, Subtask $subtask)
{
    // 🔒 Cegah update jika project sudah approved
    if ($subtask->card->board->project->status === 'approved') {
        return back()->with('error', '❌ Project sudah approved, tidak bisa memperbarui subtask.');
    }
    $request->validate([
        'subtask_title'   => 'required|string|max:150',
        'description'     => 'nullable|string',
        'estimated_hours' => 'nullable|numeric|min:0',
        'position'        => 'nullable|integer|min:1',
    ]);

    $subtask->update([
        'subtask_title'   => $request->subtask_title,
        'description'     => $request->description,
        'estimated_hours' => $request->estimated_hours,
        'position'        => $request->position ?? $subtask->position,
    ]);

    $this->updateCardActualHours($subtask->card_id);
    $this->updateCardStatus($subtask->card);

    // redirect sesuai role
    $role = strtolower(Auth::user()->role);
    if ($role === 'developer') {
        return redirect()->route('developer.dashboard')->with('success', '✏️ Subtask berhasil diperbarui');
    }
    if ($role === 'designer') {
        return redirect()->route('designer.dashboard')->with('success', '✏️ Subtask berhasil diperbarui');
    }

    // Jika role lain mencoba akses
    return back()->with('error', '❌ Hanya developer dan designer yang dapat memperbarui subtask.');
}

    /**
     * Hapus subtask
     */
    public function destroy(Subtask $subtask)
    {
        if ($subtask->card->board->project->status === 'approved') {
        return back()->with('error', '❌ Project sudah approved, tidak bisa menghapus subtask.');
    }
        if ($subtask->status === 'in_progress') {
        return back()->with('error', '❌ Subtask sedang dikerjakan, tidak bisa dihapus');
    }
        $card = $subtask->card;
        $subtask->delete();

        $this->updateCardActualHours($card->card_id);
        $this->updateCardStatus($card);

        return back()->with('success', '🗑️ Subtask berhasil dihapus');
    }

    /**
     * Start subtask
     */
    public function start(Subtask $subtask)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['developer', 'designer'])) {
            abort(403, 'Hanya developer/designer yang boleh mulai subtask');
        }

        $subtask->update(['status' => 'in_progress']);

        TimeLog::create([
            'card_id'    => $subtask->card_id,
            'subtask_id' => $subtask->subtask_id,
            'user_id'    => $user->user_id,
            'start_time' => Carbon::now('Asia/Jakarta'),
            'end_time'   => null,
            'duration_minutes' => null,
            'description'=> '🚀 Mulai subtask'
        ]);

        $card = $subtask->card;
        $inProgressBoard = Board::where('project_id', $card->board->project_id ?? null)
            ->where('board_name', 'In Progress')
            ->first();

        if ($inProgressBoard) {
            $card->update(['status' => 'in_progress', 'board_id' => $inProgressBoard->board_id]);
        }

        return back()->with('success', '🚀 Subtask dimulai');
    }

    /**
     * Complete subtask -> status review
     */
    public function complete(Subtask $subtask)
    {
        $user = Auth::user();
        if (!in_array($user->role, ['developer', 'designer'])) {
            abort(403, 'Hanya developer/designer yang boleh menyelesaikan subtask');
        }

        // Tutup log aktif
        $log = TimeLog::where('subtask_id', $subtask->subtask_id)
            ->where('user_id', $user->user_id)
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($log) {
            $end = Carbon::now('Asia/Jakarta');
            $start = $log->start_time instanceof Carbon 
                ? $log->start_time 
                : Carbon::parse($log->start_time, 'Asia/Jakarta');
            $minutes = $end->diffInMinutes($start);

            $log->update([
                'end_time' => $end,
                'duration_minutes' => $minutes,
            ]);
        }

        // Hitung ulang actual_hours dari semua log
        $totalMinutes = TimeLog::where('subtask_id', $subtask->subtask_id)->sum('duration_minutes');

        $subtask->update([
            'status' => 'review',
            'actual_hours' => round($totalMinutes / 60, 2),
        ]);
         $this->updateCardActualHours($subtask->card_id);
         $this->updateCardStatus($subtask->card);

        $card = $subtask->card;
        $reviewBoard = Board::where('project_id', $card->board->project_id ?? null)
            ->where('board_name', 'Review')
            ->first();

        if ($reviewBoard) {
            $card->update(['status' => 'review', 'board_id' => $reviewBoard->board_id]);
        }

        return back()->with('success', '✅ Subtask selesai. Menunggu approval Team Lead');
    }

    /**
     * Approve subtask -> hanya Team Lead
     */
    public function approve(Subtask $subtask)
    {
        $user = Auth::user();
        if ($user->role !== 'team_lead') {
            abort(403, 'Hanya Team Lead yang boleh approve subtask');
        }

        $subtask->update([
            'status' => 'done',
            'reject_reason' => null,
        ]);
         $this->updateCardActualHours($subtask->card_id);
         $this->updateCardStatus($subtask->card);

        $card = $subtask->card;
        $unfinished = $card->subtasks()->where('status', '!=', 'done')->count();

        if ($unfinished == 0) {
            $doneBoard = Board::where('project_id', $card->board->project_id ?? null)
                ->where('board_name', 'Done')
                ->first();

            if ($doneBoard) {
                $card->update(['status' => 'done', 'board_id' => $doneBoard->board_id]);
            } else {
                $card->update(['status' => 'done']);
            }
        }

        return back()->with('success', '☑️ Subtask disetujui & card selesai');
    }

    /**
     * Reject subtask -> hanya Team Lead
     */
    public function reject(Request $request, Subtask $subtask)
    {
        $user = Auth::user();
        if ($user->role !== 'team_lead') {
            abort(403, 'Hanya Team Lead yang boleh reject subtask');
        }

        $request->validate([
            'reason' => 'required|string|max:500',
        ]);

        $subtask->update([
            'status' => 'in_progress',
            'reject_reason' => $request->reason,
        ]);
        $this->updateCardStatus($subtask->card);

        $log = TimeLog::where('subtask_id', $subtask->subtask_id)
            ->whereNull('end_time')
            ->latest('start_time')
            ->first();

        if ($log) {
            $end = Carbon::now('Asia/Jakarta');
            $start = $log->start_time instanceof Carbon 
                ? $log->start_time 
                : Carbon::parse($log->start_time, 'Asia/Jakarta');
            $minutes = $end->diffInMinutes($start);

            $log->update([
                'end_time' => $end,
                'duration_minutes' => $minutes,
                'description' => "❌ Rejected by Team Lead: {$request->reason}",
            ]);
        } else {
            TimeLog::create([
                'card_id'    => $subtask->card_id,
                'subtask_id' => $subtask->subtask_id,
                'user_id'    => $subtask->card->assignments->first()->user_id ?? null,
                'start_time' => Carbon::now('Asia/Jakarta'),
                'end_time'   => Carbon::now('Asia/Jakarta'),
                'duration_minutes' => 0,
                'description' => "❌ Rejected by Team Lead: {$request->reason}",
            ]);
        }

        TimeLog::create([
            'card_id'    => $subtask->card_id,
            'subtask_id' => $subtask->subtask_id,
            'user_id'    => $subtask->card->assignments->first()->user_id ?? null,
            'start_time' => Carbon::now('Asia/Jakarta'),
            'end_time'   => null,
            'duration_minutes' => null,
            'description' => "🔄 Rework setelah reject",
        ]);

        $totalMinutes = TimeLog::where('subtask_id', $subtask->subtask_id)->sum('duration_minutes');

        $subtask->update([
            'actual_hours' => round($totalMinutes / 60, 2),
        ]);
          $this->updateCardActualHours($subtask->card_id);

        $card = $subtask->card;
        $inProgressBoard = Board::where('project_id', $card->board->project_id ?? null)
            ->where('board_name', 'In Progress')
            ->first();

        if ($inProgressBoard) {
            $card->update(['status' => 'in_progress', 'board_id' => $inProgressBoard->board_id]);
        }

        return back()->with('success', '❌ Subtask direject & otomatis masuk ke sesi Rework');
    }
    public function block(Subtask $subtask)
{
    $user = Auth::user();

    // Validasi role
    if (!in_array($user->role, ['developer', 'designer'])) {
        abort(403, 'Hanya developer/designer yang dapat melaporkan blocker');
    }

    // Update status blocker
    $subtask->update([
        'is_blocked'   => 1, // gunakan angka, bukan true
        'block_reason' => 'Hambatan ditemukan, menunggu solusi Team Lead',
    ]);

    $this->updateCardStatus($subtask->card);

    return back()->with('warning', '🚫 Subtask dilaporkan sebagai blocker. Menunggu respon Team Lead.');
}
    public function solveBlocker()
    {
        $user = Auth::user();

        if ($user->role !== 'team_lead') {
            abort(403, 'Hanya Team Lead yang bisa mengakses halaman ini');
        }

        $blockers = Subtask::with('card.board.project')
            ->where('is_blocked', true)
            ->whereHas('card.board.project.members', function ($query) use ($user) {
                $query->where('user_id', $user->user_id);
            })
            ->get();

        return view('teamlead.solve_blocker', compact('blockers'));
    }
    
    public function solveBlockerAction(Request $request, Subtask $subtask)
{
    $user = Auth::user();
    if ($user->role !== 'team_lead') {
        abort(403, 'Hanya Team Lead yang bisa menyelesaikan blocker');
    }

    $request->validate([
        'solution' => 'required|string|max:500',
    ]);

    $subtask->update([
        'is_blocked' => 0,
        'block_reason' => "✅ Diselesaikan oleh Team Lead: " . $request->solution,
    ]);

    $this->updateCardStatus($subtask->card);

    return back()->with('success', '✅ Blocker telah diselesaikan oleh Team Lead');
}
}