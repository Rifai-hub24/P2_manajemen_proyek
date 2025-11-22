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
     * Tambah anggota ke project
     */
    public function addMember(Request $request, $projectId)
    {
        $project = Project::findOrFail($projectId);

        if ($project->status === 'approved') {
            return back()->with('error', '❌ Project sudah approved, tidak bisa menambah anggota.');
        }

        $user = User::where('username', $request->username)->first();
        if (!$user) return back()->with('error', '❌ User tidak ditemukan!');

        $allowedRoles = ['admin','team_lead','developer','designer'];
        if (!in_array($user->role, $allowedRoles)) {
            return back()->with('error', '🚫 Role user tidak valid untuk bergabung ke project.');
        }

        if ($user->role === 'admin' && $project->members->where('role','admin')->count() > 0) {
            return back()->with('error', '⚠️ Project ini sudah memiliki Admin.');
        }

        if ($user->role !== 'admin' && $user->current_task_status === 'working') {
            return back()->with('error', '⚠️ User sedang bekerja di project lain.');
        }

        // 🔥 Simpan role aslinya ke "role_at_join"
        ProjectMember::create([
            'project_id'   => $projectId,
            'user_id'      => $user->user_id,
            'role'         => $user->role === 'admin' ? 'admin' : 'member',
            'role_at_join' => $user->role,     // <-- penting!
            'joined_at'    => now(),
        ]);

        if ($user->role !== 'admin') {
            $user->update(['current_task_status' => 'working']);
        }

        return back()->with('success', '✅ Anggota berhasil ditambahkan ke project!');
    }


    /**
     * Update anggota project
     */
    public function updateUser(Request $request, $memberId)
    {
        $member = ProjectMember::with('project', 'user')->findOrFail($memberId);

        if ($member->project->status === 'approved') {
            return back()->with('error', '❌ Project sudah approved, tidak bisa edit anggota.');
        }

        // Cegah edit ketika subtask jalan
        $hasStarted = Subtask::whereHas('card.board', function($q) use ($member) {
            $q->where('project_id', $member->project->project_id);
        })->where('status', 'in_progress')->exists();

        if ($hasStarted) return back()->with('error', '⚠️ Tidak bisa edit anggota, subtask sudah berjalan.');

        $request->validate([
            'username' => 'required|string|exists:users,username'
        ]);

        $newUser = User::where('username', $request->username)->first();
        if (!$newUser) return back()->with('error', '❌ User tidak ditemukan.');

        $allowedRoles = ['admin','team_lead','developer','designer'];
        if (!in_array($newUser->role, $allowedRoles)) {
            return back()->with('error', '🚫 Role user tidak valid.');
        }

        // Admin hanya diganti admin
        if ($member->role === 'admin' && $newUser->role !== 'admin') {
            return back()->with('error', '🚫 Admin hanya bisa diganti admin.');
        }

        // ganti admin tetapi project sudah ada admin lain
        if ($newUser->role === 'admin' &&
            $member->project->members
                ->where('role','admin')
                ->where('member_id','!=',$member->member_id)
                ->count() > 0) {

            return back()->with('error', '⚠️ Project sudah memiliki admin.');
        }

        if ($newUser->role !== 'admin' && $newUser->current_task_status === 'working') {
            return back()->with('error', '⚠️ User sedang bekerja di project lain.');
        }

        // Hapus card user lama
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

        // Reset status user lama
        if ($member->user->role !== 'admin') {
            $member->user->update(['current_task_status' => 'idle']);
        }

        // 🔥 Update user baru TANPA mengubah role_at_join
        $member->update([
            'user_id' => $newUser->user_id,
            'role'    => $newUser->role === 'admin' ? 'admin' : 'member',
            // role_at_join tetap → tidak dihapus, tidak diganti
        ]);

        if ($newUser->role !== 'admin') {
            $newUser->update(['current_task_status' => 'working']);
        }

        return back()->with('success', '✅ Anggota berhasil diganti!');
    }


    /**
     * Hapus anggota project
     */
    public function deleteMember($memberId)
    {
        $member = ProjectMember::with(['project', 'user'])->findOrFail($memberId);

        if ($member->user->role === 'admin') {
            return back()->with('error', '🚫 Admin tidak dapat dihapus.');
        }

        $hasStarted = Subtask::whereHas('card.board', function($q) use ($member) {
            $q->where('project_id', $member->project->project_id);
        })->where('status', 'in_progress')->exists();

        if ($hasStarted) {
            return back()->with('error', '⚠️ Tidak bisa hapus anggota, subtask sudah berjalan.');
        }

        // hapus card user
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

        if ($member->user->role !== 'admin') {
            $member->user->update(['current_task_status' => 'idle']);
        }

        $member->delete();

        return back()->with('success', '🗑️ Anggota berhasil dihapus!');
    }


    // TEAM VIEW
    public function myTeam()
    {
        $user = auth()->user();

        $projects = Project::whereHas('members', function($q) use ($user) {
            $q->where('user_id', $user->user_id);
        })->with(['members.user'])->get();

        return view('teamlead.myteam', compact('projects','user'));
    }

    public function developerTeam()
    {
        $user = auth()->user();

        $projects = Project::whereHas('members', function($q) use ($user) {
            $q->where('user_id', $user->user_id);
        })->with(['members.user'])->get();

        $hasApprovedOnly = $projects->every(fn($p) => $p->status === 'approved');

        return view('developer.myteam', compact('projects','user','hasApprovedOnly'));
    }

    public function designerTeam()
    {
        $user = auth()->user();

        $projects = Project::whereHas('members', function($q) use ($user) {
            $q->where('user_id', $user->user_id);
        })->with(['members.user'])->get();

        $hasApprovedOnly = $projects->every(fn($p) => $p->status === 'approved');

        return view('designer.myteam', compact('projects','user','hasApprovedOnly'));
    }
}
