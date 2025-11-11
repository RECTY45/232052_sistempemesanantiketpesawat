<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Airport;
use Illuminate\Http\Request;

class AirportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airports = Airport::orderBy('name')->paginate(10);
        
        return view('admin.airports.index', [
            'title' => 'Travelo | Kelola Bandara',
            'name' => 'Travelo',
            'airports' => $airports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.airports.create', [
            'title' => 'Travelo | Tambah Bandara',
            'name' => 'Travelo'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airports,code',
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        Airport::create($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Bandara berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Airport $airport)
    {
        return view('admin.airports.show', [
            'title' => 'Travelo | Detail Bandara',
            'name' => 'Travelo',
            'airport' => $airport->load(['departureFlights', 'arrivalFlights'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Airport $airport)
    {
        return view('admin.airports.edit', [
            'title' => 'Travelo | Edit Bandara',
            'name' => 'Travelo',
            'airport' => $airport
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Airport $airport)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:10|unique:airports,code,' . $airport->id,
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'timezone' => 'required|string|max:50',
            'is_active' => 'boolean'
        ]);

        $airport->update($validated);

        return redirect()->route('admin.airports.index')
            ->with('success', 'Bandara berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Airport $airport)
    {
        try {
            // Check if airport has flights
            $flightsCount = $airport->departureFlights()->count() + $airport->arrivalFlights()->count();
            
            if ($flightsCount > 0) {
                return back()->with('error', 'Bandara tidak dapat dihapus karena masih memiliki jadwal penerbangan.');
            }

            $airport->delete();

            return redirect()->route('admin.airports.index')
                ->with('success', 'Bandara berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus bandara. ' . $e->getMessage());
        }
    }
}
