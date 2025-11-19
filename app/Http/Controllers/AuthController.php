<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // 🔹 Tampilkan halaman login
    public function showLogin()
    {
        return view('auth.login');
    }

    // 🔹 Proses login manual (username atau email)
    public function login(Request $request)
    {
        $loginInput = $request->input('login'); // Bisa username atau email
        $password   = $request->input('password');

        // Cari user berdasarkan username atau email
        $user = User::where('username', $loginInput)
                    ->orWhere('email', $loginInput)
                    ->first();

        if ($user && Hash::check($password, $user->password)) {
            if ($user->role === 'keluar') {
                return back()->with('error', '⚠️ User ini telah keluar dari perusahaan.');
            }
            Auth::login($user);
            $request->session()->regenerate();

            // Simpan info tambahan di session
            session([
                'user_id'   => $user->user_id,
                'role'      => $user->role,
                'username'  => $user->username,
                'full_name' => $user->full_name
            ]);

            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Username/Email atau password salah');
    }

    // 🔹 Proses logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
