<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login()
    {
        return view('auth.login', [
            'title' => 'Login Travelo',
            'name' => 'Travelo'
        ]);
    }

    public function AuthLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required'],
            'password' => ['required'],
        ]);

        // Ambil user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan.');
        }

        // Cek status user
        if ($user->status !== 'aktif') {
            return back()->with('error', 'Akun Anda nonaktif. Silakan aktifkan terlebih dahulu.');
        }

        // Jika status aktif, baru lakukan attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('dash.index'))
                ->with('success', 'Login berhasil! Selamat datang, ' . $user->name . '.');
        }

        // Jika password salah
        return back()->with('error', 'Login gagal! Email atau password salah.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('auth/login')->with('success', 'Anda telah logout.');
    }
}
