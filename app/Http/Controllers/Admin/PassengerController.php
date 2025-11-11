<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Passenger;
use Illuminate\Http\Request;

class PassengerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Passenger::with(['booking.flight.departureAirport', 'booking.flight.arrivalAirport']);
        
        // Filter by name
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->search . '%')
                  ->orWhere('last_name', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter by passenger type
        if ($request->filled('passenger_type')) {
            $query->where('passenger_type', $request->passenger_type);
        }
        
        // Filter by gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }
        
        // Filter by nationality
        if ($request->filled('nationality')) {
            $query->where('nationality', 'like', '%' . $request->nationality . '%');
        }
        
        $passengers = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $stats = [
            'total_passengers' => Passenger::count(),
            'adult_passengers' => Passenger::where('passenger_type', 'adult')->count(),
            'child_passengers' => Passenger::where('passenger_type', 'child')->count(),
            'infant_passengers' => Passenger::where('passenger_type', 'infant')->count(),
        ];
        
        $title = 'Manajemen Penumpang - Travelo Admin';
        
        return view('admin.passengers.index', compact('passengers', 'stats', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin tidak perlu create passenger manual
        return redirect()->route('admin.passengers.index')
            ->with('info', 'Data penumpang dibuat otomatis dari sistem pemesanan.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin tidak perlu create passenger manual
        return redirect()->route('admin.passengers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Passenger $passenger)
    {
        $passenger->load([
            'booking.user',
            'booking.flight.airline',
            'booking.flight.aircraft',
            'booking.flight.departureAirport',
            'booking.flight.arrivalAirport'
        ]);
        
        $title = 'Detail Penumpang ' . $passenger->full_name . ' - Travelo Admin';
        
        return view('admin.passengers.show', compact('passenger', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Passenger $passenger)
    {
        return redirect()->route('admin.passengers.show', $passenger)
            ->with('info', 'Data penumpang tidak dapat diedit untuk menjaga integritas data.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Passenger $passenger)
    {
        return redirect()->route('admin.passengers.show', $passenger)
            ->with('info', 'Data penumpang tidak dapat diubah untuk menjaga integritas data.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Passenger $passenger)
    {
        // Check if booking is still active
        if ($passenger->booking->status !== 'cancelled') {
            return redirect()->route('admin.passengers.index')
                ->with('error', 'Data penumpang tidak dapat dihapus karena pemesanan masih aktif.');
        }
        
        $passenger->delete();
        
        return redirect()->route('admin.passengers.index')
            ->with('success', 'Data penumpang berhasil dihapus!');
    }
}
