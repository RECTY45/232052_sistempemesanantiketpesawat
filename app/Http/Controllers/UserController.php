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
        //
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
        //
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
