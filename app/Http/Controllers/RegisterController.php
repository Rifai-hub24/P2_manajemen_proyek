<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'username'  => 'required|unique:users,username',
            'full_name' => 'required|string|max:100',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
        ]);

        User::create([
            'username'  => $request->username,
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'role'      => 'pending',
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Tunggu admin menyetujui akun Anda.');
    }
}