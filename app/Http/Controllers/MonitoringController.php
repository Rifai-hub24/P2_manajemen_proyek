<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Board;
use App\Models\Card;

class MonitoringController extends Controller
{
    // List semua project yg dipimpin admin login
    public function index()
    {
        $userId = auth()->id();

        $projects = Project::whereHas('members', function ($q) use ($userId) {
            $q->where('user_id', $userId)->where('role', 'admin');
        })->get();

        return view('admin.monitoring.index', compact('projects'));
    }

    // Detail project → tampilkan semua boards
    public function show(Project $project)
    {
        $this->authorizeProject($project);

        $project->load('boards.cards');
        return view('admin.monitoring.show', compact('project'));
    }

    // Tampilkan cards di 1 board
    public function board(Project $project, Board $board)
    {
        $this->authorizeProject($project);

        $board->load('cards');
        return view('admin.monitoring.board', compact('project', 'board'));
    }

       // Detail card + subtasks (view only)
       public function card($projectId, $cardId)
    {
       // Ambil project untuk header
       $project = Project::with('boards.cards')->findOrFail($projectId);

       // Ambil card + relasi subtasks, assignments, dan comments
       $card = Card::with([
          'subtasks',
          'assignments.user',   // supaya anggota muncul
          'comments.user'       // supaya komentar muncul dengan nama user
       ])->findOrFail($cardId);

      return view('admin.monitoring.card', compact('project', 'card'));
   }


    // Cek apakah user login memang admin di project ini
    private function authorizeProject(Project $project)
    {
        $isAdmin = $project->members()
            ->where('user_id', auth()->id())
            ->where('role', 'admin')
            ->exists();

        if (!$isAdmin) {
            abort(403, 'Anda tidak memiliki akses ke project ini.');
        }
    }
   public function chart($id)
{
    // Ambil project lengkap
    $project = Project::with([
        'boards.cards.assignments.user',
        'members.user'
    ])->findOrFail($id);

    // Ambil semua card
    $cards = $project->boards->flatMap->cards;

    // -----------------------------
    // HITUNG STATUS PROGRES
    // -----------------------------
    $todo       = $cards->where('status', 'todo')->count();
    $inProgress = $cards->where('status', 'in_progress')->count();
    $review     = $cards->where('status', 'review')->count();
    $done       = $cards->where('status', 'done')->count();

    $totalCards = $cards->count();          // jumlah card keseluruhan
    $completed  = $done;                    // card selesai

    $progress = $totalCards > 0
        ? round((($done * 1) + ($review * 0.8) + ($inProgress * 0.5)) / $totalCards * 100)
        : 0;

    // -----------------------------
    // PRODUKTIVITAS USER
    // -----------------------------
    $users = [];

    foreach ($cards as $card) {
        foreach ($card->assignments as $assign) {

            $user = $assign->user;
            if (!$user) continue; // user sudah dihapus

            // Jika user belum dicatat -> buat entry
            if (!isset($users[$assign->user_id])) {

                // Ambil role_at_join dari project_members
                $roleAtJoin = optional(
                    $project->members->firstWhere('user_id', $assign->user_id)
                )->role_at_join;

                // Role final
                $finalRole = in_array($user->role, ['developer', 'designer'])
                    ? $user->role
                    : $roleAtJoin;

                $users[$assign->user_id] = [
                    'user_id'   => $assign->user_id,
                    'username'  => $user->username ?? 'Unknown',
                    'estimated' => 0,
                    'actual'    => 0,
                    'role'      => $finalRole ?? 'unknown',
                ];
            }

            // Tambahkan jam
            $users[$assign->user_id]['estimated'] += ($card->estimated_hours ?? 0);
            $users[$assign->user_id]['actual']    += ($card->actual_hours ?? 0);
        }
    }

    // Hitung persentase produktivitas
    $productivity = collect($users)->map(function ($u) {
        $u['percentage'] = $u['estimated'] > 0
            ? round(($u['actual'] / $u['estimated']) * 100)
            : 0;
        return $u;
    });

    // -----------------------------
    // FILTER ROLE: DEV & DESIGNER
    // -----------------------------
    $devProductivity      = $productivity->where('role', 'developer')->values();
    $designerProductivity = $productivity->where('role', 'designer')->values();

    // --------------------------------
    // DATA UNTUK STACKED BAR CHART
    // --------------------------------
    $devData = [
        'labels'    => $devProductivity->pluck('username')->values(),
        'estimated' => $devProductivity->pluck('estimated')->values(),
        'actual'    => $devProductivity->pluck('actual')->values(),
    ];

    $designerData = [
        'labels'    => $designerProductivity->pluck('username')->values(),
        'estimated' => $designerProductivity->pluck('estimated')->values(),
        'actual'    => $designerProductivity->pluck('actual')->values(),
    ];

    // -----------------------------
    // KIRIM KE BLADE
    // -----------------------------
    return view('admin.monitoring.chart', compact(
        'project',
        'todo',
        'inProgress',
        'review',
        'done',
        'progress',
        'totalCards',
        'completed',
        'devProductivity',
        'designerProductivity',
        'devData',
        'designerData'
    ));
}

}
