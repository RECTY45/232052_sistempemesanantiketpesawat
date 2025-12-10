<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Aircraft;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FlightController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Flight::with(['airline', 'aircraft', 'departureAirport', 'arrivalAirport']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by airline
        if ($request->filled('airline')) {
            $query->where('airline_id', $request->airline);
        }

        // Filter by route
        if ($request->filled('departure') || $request->filled('arrival')) {
            if ($request->filled('departure')) {
                $query->where('departure_airport_id', $request->departure);
            }
            if ($request->filled('arrival')) {
                $query->where('arrival_airport_id', $request->arrival);
            }
        }

        // Filter by date
        if ($request->filled('date')) {
            $query->whereDate('departure_time', $request->date);
        }

        $flights = $query->orderBy('departure_time', 'asc')->paginate(15);
        
        $airlines = Airline::active()->orderBy('name')->get();
        $airports = Airport::active()->orderBy('name')->get();
        
        return view('admin.flights.index', [
            'title' => 'Travelo | Kelola Penerbangan',
            'name' => 'Travelo',
            'flights' => $flights,
            'airlines' => $airlines,
            'airports' => $airports
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $airlines = Airline::active()->orderBy('name')->get();
        $airports = Airport::active()->orderBy('name')->get();
        $aircraft = Aircraft::active()->with('airline')->orderBy('model')->get();
        
        return view('admin.flights.create', [
            'title' => 'Travelo | Tambah Penerbangan',
            'name' => 'Travelo',
            'airlines' => $airlines,
            'airports' => $airports,
            'aircraft' => $aircraft
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'flight_number' => 'required|string|max:20|unique:flights,flight_number',
            'airline_id' => 'required|exists:airlines,id',
            'aircraft_id' => 'required|exists:aircraft,id',
            'departure_airport_id' => 'required|exists:airports,id|different:arrival_airport_id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_time' => 'required|date|after:now',
            'arrival_time' => 'required|date|after:departure_time',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_class_price' => 'nullable|numeric|min:0',
            'gate' => 'nullable|string|max:10',
            'is_active' => 'boolean'
        ]);

        // Calculate duration
        $departure = Carbon::parse($validated['departure_time']);
        $arrival = Carbon::parse($validated['arrival_time']);
        $validated['duration_minutes'] = $departure->diffInMinutes($arrival);

        // Get aircraft seat availability
        $aircraft = Aircraft::find($validated['aircraft_id']);
        $validated['available_economy_seats'] = $aircraft->economy_seats;
        $validated['available_business_seats'] = $aircraft->business_seats;
        $validated['available_first_class_seats'] = $aircraft->first_class_seats;

        Flight::create($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Penerbangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Flight $flight)
    {
        $flight->load(['airline', 'aircraft', 'departureAirport', 'arrivalAirport', 'bookings.user']);
        
        return view('admin.flights.show', [
            'title' => 'Travelo | Detail Penerbangan',
            'name' => 'Travelo',
            'flight' => $flight
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Flight $flight)
    {
        $airlines = Airline::active()->orderBy('name')->get();
        $airports = Airport::active()->orderBy('name')->get();
        $aircraft = Aircraft::active()->with('airline')->orderBy('model')->get();
        
        return view('admin.flights.edit', [
            'title' => 'Travelo | Edit Penerbangan',
            'name' => 'Travelo',
            'flight' => $flight,
            'airlines' => $airlines,
            'airports' => $airports,
            'aircraft' => $aircraft
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Flight $flight)
    {
        // Custom validation rule for departure time
        $departureValidation = 'required|date';

        if ($flight->departure_time->isPast()) {
            // Allow editing past flights but prevent moving the schedule further back
            $departureValidation .= '|after_or_equal:' . $flight->departure_time->format('Y-m-d H:i:s');
        } else {
            $departureValidation .= '|after:now';
        }

        $validated = $request->validate([
            'flight_number' => 'required|string|max:20|unique:flights,flight_number,' . $flight->id,
            'airline_id' => 'required|exists:airlines,id',
            'aircraft_id' => 'required|exists:aircraft,id',
            'departure_airport_id' => 'required|exists:airports,id|different:arrival_airport_id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_time' => $departureValidation,
            'arrival_time' => 'required|date|after:departure_time',
            'economy_price' => 'required|numeric|min:0',
            'business_price' => 'nullable|numeric|min:0',
            'first_class_price' => 'nullable|numeric|min:0',
            'status' => 'required|in:scheduled,delayed,cancelled,completed',
            'gate' => 'nullable|string|max:10',
            'is_active' => 'boolean'
        ], [
            'departure_time.after' => 'Waktu keberangkatan tidak boleh di masa lalu.',
            'departure_time.after_or_equal' => 'Waktu keberangkatan tidak boleh di masa lalu.',
            'arrival_time.after' => 'Waktu kedatangan harus setelah waktu keberangkatan.',
            'departure_airport_id.different' => 'Bandara keberangkatan dan kedatangan harus berbeda.'
        ]);

        // Calculate duration
        $departure = Carbon::parse($validated['departure_time']);
        $arrival = Carbon::parse($validated['arrival_time']);
        $validated['duration_minutes'] = $departure->diffInMinutes($arrival);

        // Update seat availability if aircraft changed
        if ($validated['aircraft_id'] != $flight->aircraft_id) {
            $aircraft = Aircraft::find($validated['aircraft_id']);
            $validated['available_economy_seats'] = $aircraft->economy_seats;
            $validated['available_business_seats'] = $aircraft->business_seats;
            $validated['available_first_class_seats'] = $aircraft->first_class_seats;
        }

        $flight->update($validated);

        return redirect()->route('admin.flights.index')
            ->with('success', 'Penerbangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Flight $flight)
    {
        try {
            // Check if flight has bookings
            if ($flight->bookings()->count() > 0) {
                return back()->with('error', 'Penerbangan tidak dapat dihapus karena sudah memiliki pemesanan.');
            }

            $flight->delete();

            return redirect()->route('admin.flights.index')
                ->with('success', 'Penerbangan berhasil dihapus!');
                
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus penerbangan. ' . $e->getMessage());
        }
    }

    /**
     * Get aircraft by airline (AJAX)
     */
    public function getAircraftByAirline($airlineId)
    {
        $aircraft = Aircraft::where('airline_id', $airlineId)
            ->where('is_active', true)
            ->get(['id', 'model', 'registration']);
            
        return response()->json($aircraft);
    }
}
