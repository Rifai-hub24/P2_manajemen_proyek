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

   
}