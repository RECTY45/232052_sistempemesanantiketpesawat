<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->filled('role')) {
            $query->where('roles', $request->role);
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        $title = 'Manajemen Pengguna - Travelo Admin';

        return view('admin.users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Tambah Pengguna - Travelo Admin';
        return view('admin.users.create', compact('title'));
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
            'roles' => 'required|in:admin,customer'
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

            return redirect()->route('admin.users.index')
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
        // Load bookings and statistics for admin view
        $bookingStats = [
            'total' => $user->bookings()->count(),
            'confirmed' => $user->bookings()->where('status', 'confirmed')->count(),
            'pending' => $user->bookings()->where('status', 'pending')->count(),
            'cancelled' => $user->bookings()->where('status', 'cancelled')->count(),
        ];

        $recentBookings = $user->bookings()
            ->with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $title = 'Detail Pengguna ' . $user->name . ' - Travelo Admin';

        return view('admin.users.show', compact('user', 'bookingStats', 'recentBookings', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $title = 'Edit Pengguna ' . $user->name . ' - Travelo Admin';
        return view('admin.users.edit', compact('user', 'title'));
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
            'roles' => 'required|in:admin,customer',
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

            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil diperbarui!');
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

        // Cegah user login menghapus dirinya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $deleted = $user->delete();

        if ($deleted) {
            return redirect()->route('admin.users.index')
                ->with('success', 'Pengguna berhasil dihapus.');
        } else {
            return redirect()->route('admin.users.index')
                ->with('error', 'Pengguna gagal dihapus.');
        }
    }
}
