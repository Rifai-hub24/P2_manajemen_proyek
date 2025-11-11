<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Menampilkan daftar user pending
     */
    public function index()
    {
        $users = User::where('role', 'pending')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Approve user (ubah dari pending ke role tertentu)
     */
    public function approve(User $user, Request $request)
    {
        $request->validate([
            'role' => 'required|in:admin,team_lead,developer,designer',
        ]);

        $user->update(['role' => $request->role]);
        return back()->with('success', "User {$user->username} disetujui sebagai {$request->role}");
    }

    /**
     * Hapus user pending
     */
    public function reject(User $user)
    {
        $user->delete();
        return back()->with('success', "User {$user->username} ditolak dan dihapus");
    }

    /**
     * Daftar user aktif (non-pending) + filter + pencarian
     */
    public function indexActive(Request $request)
    {
        $query = User::whereIn('role', ['admin','team_lead','developer','designer']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where('username', 'like', '%' . $request->search . '%');
        }

        $users = $query->get();

        return view('admin.users.active', compact('users'));
    }

    /**
     * Update role user (admin tidak boleh ubah admin)
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,team_lead,developer,designer',
        ]);

        $currentUser = Auth::user();

        // Cegah admin edit sesama admin
        if ($currentUser->role === 'admin' && $user->role === 'admin') {
            return back()->with('error', '🚫 Anda tidak dapat mengubah role sesama admin.');
        }

        // Cegah admin ubah dirinya sendiri
        if ($currentUser->user_id === $user->user_id) {
            return back()->with('error', '⚠️ Anda tidak dapat mengubah role diri sendiri.');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', "✅ Role user {$user->username} berhasil diubah menjadi {$request->role}");
    }

    /**
     * Hapus user (admin tidak bisa hapus sesama admin)
     */
    public function destroy(User $user)
    {
        $currentUser = Auth::user();

        // Cegah admin hapus admin
        if ($currentUser->role === 'admin' && $user->role === 'admin') {
            return back()->with('error', '🚫 Anda tidak dapat menghapus sesama admin.');
        }

        // Cegah admin hapus diri sendiri
        if ($currentUser->user_id === $user->user_id) {
            return back()->with('error', '⚠️ Anda tidak dapat menghapus diri sendiri.');
        }

        $user->delete();

        return back()->with('success', "🗑️ User {$user->username} berhasil dihapus.");
    }
}