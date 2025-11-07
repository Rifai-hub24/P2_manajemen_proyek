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
}
