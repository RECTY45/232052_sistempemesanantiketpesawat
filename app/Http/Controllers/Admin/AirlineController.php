<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AirlineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airlines = Airline::orderBy('name')->get();
        
        return view('admin.airlines.index', [
            'title' => 'Travelo | Kelola Maskapai',
            'name' => 'Travelo',
            'airlines' => $airlines
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.airlines.create', [
            'title' => 'Travelo | Tambah Maskapai',
            'name' => 'Travelo'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airlines,code',
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'country' => 'required|string|max:100',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('airlines', 'public');
        }

        Airline::create($validated);

        return redirect()->route('admin.airlines.index')
            ->with('success', 'Maskapai berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Airline $airline)
    {
        return view('admin.airlines.show', [
            'title' => 'Travelo | Detail Maskapai',
            'name' => 'Travelo',
            'airline' => $airline->load(['aircraft', 'flights'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airline $airline)
    {
        return view('admin.airlines.edit', [
            'title' => 'Travelo | Edit Maskapai',
            'name' => 'Travelo',
            'airline' => $airline
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airline $airline)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airlines,code,' . $airline->id,
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'country' => 'required|string|max:100',
            'website' => 'nullable|url',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean'
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($airline->logo) {
                Storage::disk('public')->delete($airline->logo);
            }
            $validated['logo'] = $request->file('logo')->store('airlines', 'public');
        }

        $airline->update($validated);

        return redirect()->route('admin.airlines.index')
            ->with('success', 'Maskapai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airline $airline)
    {
        try {
            // Check if airline has flights
            if ($airline->flights()->count() > 0) {
                return back()->with('error', 'Maskapai tidak dapat dihapus karena masih memiliki jadwal penerbangan.');
            }

            // Delete logo if exists
            if ($airline->logo) {
                Storage::disk('public')->delete($airline->logo);
            }

            $airline->delete();

            return redirect()->route('admin.airlines.index')
                ->with('success', 'Maskapai berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus maskapai. ' . $e->getMessage());
        }
    }
}
