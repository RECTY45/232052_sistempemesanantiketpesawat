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
            $query->where(function($q) use ($request) {
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
        $title = 'Tambah Pengguna Baru - Travelo Admin';
        return view('admin.users.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'required|in:admin,customer',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        // Load user's booking statistics for customers
        $bookingStats = [
            'total' => $user->bookings()->count(),
            'confirmed' => $user->bookings()->where('status', 'confirmed')->count(),
            'pending' => $user->bookings()->where('status', 'pending')->count(),
            'cancelled' => $user->bookings()->where('status', 'cancelled')->count(),
        ];

        // Get recent bookings for customers
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
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'required|in:admin,customer',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Check if user has bookings
        if ($user->bookings()->count() > 0) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Pengguna tidak dapat dihapus karena memiliki riwayat pemesanan.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna berhasil dihapus!');
    }
}
