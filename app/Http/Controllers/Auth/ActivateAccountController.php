<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ActivateAccountController extends Controller
{
    /**
     * Aktifkan akun berdasarkan token aktivasi.
     */
    public function activate($token)
    {
        // Cari user berdasarkan activation token
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('AuthLogin')
                ->with('error', 'Token aktivasi tidak valid atau sudah digunakan. Silakan coba daftar ulang atau hubungi administrator.');
        }

        // Cek apakah akun sudah diaktifkan sebelumnya
        if ($user->status === 'aktif' && $user->email_verified_at) {
            return redirect()->route('AuthLogin')
                ->with('info', 'Akun Anda sudah aktif. Silakan login.');
        }

        try {
            // Update status akun dan email verification
            $user->update([
                'status' => 'aktif',
                'email_verified_at' => Carbon::now(),
                'activation_token' => null, // Hapus token setelah digunakan
            ]);

            return redirect()->route('AuthLogin')
                ->with('success', 'Selamat! Akun Anda berhasil diaktifkan. Sekarang Anda dapat login dengan email dan password yang telah didaftarkan.');
                
        } catch (\Exception $e) {
            \Log::error('Account activation failed for user ID: ' . $user->id . '. Error: ' . $e->getMessage());
            
            return redirect()->route('AuthLogin')
                ->with('error', 'Terjadi kesalahan saat mengaktifkan akun. Silakan coba lagi atau hubungi administrator.');
        }
    }
}
