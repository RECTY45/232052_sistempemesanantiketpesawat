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
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password harus diisi.',
        ]);

        // Ambil user berdasarkan email
        $user = \App\Models\User::where('email', $request->email)->first();

        // Cek apakah user ada
        if (!$user) {
            return back()->with('error', 'Email tidak ditemukan dalam sistem kami.')
                         ->withInput($request->only('email'));
        }

        // Cek apakah password cocok terlebih dahulu
        if (!Auth::attempt($credentials)) {
            return back()->with('error', 'Password yang Anda masukkan salah.')
                         ->withInput($request->only('email'));
        }

        // Cek status user
        if ($user->status !== 'aktif') {
            Auth::logout(); // Logout jika tidak aktif
            return back()->with('error', 'Akun Anda belum diaktifkan. Silakan cek email Anda untuk aktivasi atau hubungi administrator.')
                         ->withInput($request->only('email'));
        }

        // Cek email verification (opsional, tapi direkomendasikan untuk keamanan)
        if (!$user->email_verified_at) {
            Auth::logout(); // Logout jika email belum diverifikasi
            return back()->with('warning', 'Email Anda belum diverifikasi. Silakan cek email untuk melakukan verifikasi.')
                         ->withInput($request->only('email'));
        }

        // Jika semua validasi passed, regenerate session dan redirect
        $request->session()->regenerate();
        
        return redirect()->intended(route('dash.index'))
            ->with('success', 'Selamat datang, ' . $user->name . '! Login berhasil.');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('auth/login')->with('success', 'Anda telah logout.');
    }
}
