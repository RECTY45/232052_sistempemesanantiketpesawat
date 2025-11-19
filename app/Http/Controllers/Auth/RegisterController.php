<?php

namespace App\Http\Controllers\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.register', [
            'title' => 'Travelo | Register',
            'name' =>  'Travelo'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ], [
            'name.required' => 'Nama harus diisi.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        try {
            // Create user dengan status nonaktif dan generate activation token
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'status' => 'nonaktif',
                'roles' => 'customer',
                'activation_token' => Str::random(64),
                'email_verified_at' => null, // Belum diverifikasi
            ]);

            // Try to send activation email
            try {
                Mail::to($user->email)->send(new ActivationMail($user));
                $message = 'Pendaftaran berhasil! Kami telah mengirim email aktivasi ke ' . $user->email . '. Silakan cek email Anda dan klik link aktivasi untuk mengaktifkan akun.';
                return redirect()->route('AuthLogin')->with('success', $message);
            } catch (\Exception $mailException) {
                // Log email error but don't fail the registration
                \Log::error('Failed to send activation email to ' . $user->email . ': ' . $mailException->getMessage());
                $message = 'Pendaftaran berhasil! Namun email aktivasi gagal dikirim. Hubungi administrator untuk aktivasi manual atau coba daftar ulang.';
                return redirect()->route('AuthLogin')->with('warning', $message);
            }
            
        } catch (Exception $e) {
            \Log::error('Registration failed: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Gagal melakukan pendaftaran: ' . $e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
