<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('user.index', [
            'title' => 'Travelo | Pengguna',
            'name' =>  'Travelo',
            'items' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create', [
            'title' => 'Travelo | Tambah Pengguna',
            'name' =>  'Travelo',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'roles' => 'required|in:admin,user'
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required' => 'Role harus dipilih.',
            'roles.in' => 'Role tidak valid.'
        ]);

        try {
            $validated['password'] = bcrypt($validated['password']);
            $validated['status'] = 'aktif';
            
            User::create($validated);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('bookings.flight.departureAirport', 'bookings.flight.arrivalAirport');
        
        return view('user.show', [
            'title' => 'Travelo | Detail Pengguna',
            'name' =>  'Travelo',
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('user.update', [
            'title' => 'Travelo | Sunting Pengguna',
            'name' =>  'Travelo',
            'item' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'roles' => 'required|in:admin,user',
            'status' => 'required|in:aktif,nonaktif'
        ], [
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'roles.required' => 'Role harus dipilih.',
            'roles.in' => 'Role tidak valid.',
            'status.required' => 'Status harus dipilih.',
            'status.in' => 'Status tidak valid.'
        ]);

        try {
            // Jika password diisi, update password
            if ($validated['password']) {
                $validated['password'] = bcrypt($validated['password']);
            } else {
                unset($validated['password']);
            }

            $user->update($validated);

            return redirect()->route('user.index')
                ->with('success', 'User berhasil diperbarui!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Gagal memperbarui user: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user = User::findOrFail($user->id);

        // ✅ Cegah user login menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('user.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $deleted = $user->delete();

        if ($deleted) {
            return redirect()->route('user.index')
                ->with('success', 'Pengguna berhasil dihapus.');
        } else {
            return redirect()->route('user.index')
                ->with('error', 'Pengguna gagal dihapus.');
        }
    }
}
