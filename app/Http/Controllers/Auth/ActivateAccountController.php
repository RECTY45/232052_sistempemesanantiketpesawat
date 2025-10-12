<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ActivateAccountController extends Controller
{
    /**
     * Aktifkan akun berdasarkan token aktivasi.
     */
    public function activate($token)
    {
        $user = User::where('activation_token', $token)->first();

        if (!$user) {
            return redirect()->route('AuthLogin')
                ->with('error', 'Token aktivasi tidak valid atau sudah digunakan.');
        }

        $user->update([
            'status' => 'aktif',
            'activation_token' => null,
        ]);

        return redirect()->route('AuthLogin')
            ->with('success', 'Akun kamu berhasil diaktifkan! Silakan login sekarang.');
    }
}
