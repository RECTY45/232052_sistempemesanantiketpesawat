<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Aircraft;
use App\Models\Airline;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AircraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aircraft = Aircraft::with('airline')
            ->paginate(10);
        
        $airlines = Airline::all();
        $title = 'Manajemen Pesawat - Travelo Admin';
        
        return view('admin.aircraft.index', compact('aircraft', 'airlines', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $airlines = Airline::where('is_active', true)->get();
        $title = 'Tambah Pesawat Baru - Travelo Admin';
        return view('admin.aircraft.create', compact('airlines', 'title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'registration' => 'required|string|max:10|unique:aircraft',
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:100',
            'economy_seats' => 'required|integer|min:0',
            'business_seats' => 'required|integer|min:0',
            'first_class_seats' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500'
        ]);

        // Calculate total seats
        $validated['total_seats'] = $validated['economy_seats'] + $validated['business_seats'] + $validated['first_class_seats'];
        
        Aircraft::create($validated);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Pesawat berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aircraft $aircraft)
    {
        $aircraft->load(['airline', 'flights.departureAirport', 'flights.arrivalAirport']);
        $title = 'Detail Pesawat ' . $aircraft->registration . ' - Travelo Admin';
        return view('admin.aircraft.show', compact('aircraft', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aircraft $aircraft)
    {
        $airlines = Airline::where('is_active', true)->get();
        $title = 'Edit Pesawat ' . $aircraft->registration . ' - Travelo Admin';
        return view('admin.aircraft.edit', compact('aircraft', 'airlines', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aircraft $aircraft)
    {
        $validated = $request->validate([
            'registration' => 'required|string|max:10|unique:aircraft,registration,' . $aircraft->id,
            'airline_id' => 'required|exists:airlines,id',
            'model' => 'required|string|max:100',
            'economy_seats' => 'required|integer|min:0',
            'business_seats' => 'required|integer|min:0',
            'first_class_seats' => 'required|integer|min:0',
            'is_active' => 'boolean',
            'description' => 'nullable|string|max:500'
        ]);

        // Calculate total seats
        $validated['total_seats'] = $validated['economy_seats'] + $validated['business_seats'] + $validated['first_class_seats'];

        $aircraft->update($validated);

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Pesawat berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aircraft $aircraft)
    {
        // Check if aircraft is being used in any flights
        if ($aircraft->flights()->count() > 0) {
            return redirect()->route('admin.aircraft.index')
                ->with('error', 'Pesawat tidak dapat dihapus karena sedang digunakan dalam penerbangan.');
        }

        $aircraft->delete();

        return redirect()->route('admin.aircraft.index')
            ->with('success', 'Pesawat berhasil dihapus!');
    }
}
