<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers']);
        
        // Filter by booking code
        if ($request->filled('booking_code')) {
            $query->where('booking_code', 'like', '%' . $request->booking_code . '%');
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        $bookings = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Statistics
        $stats = [
            'total_bookings' => Booking::count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'cancelled_bookings' => Booking::where('status', 'cancelled')->count(),
        ];
        
        $title = 'Manajemen Booking - Travelo Admin';
        
        return view('admin.bookings.index', compact('bookings', 'stats', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Admin tidak perlu create booking manual
        return redirect()->route('admin.bookings.index')
            ->with('info', 'Pemesanan dibuat melalui sistem customer.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Admin tidak perlu create booking manual
        return redirect()->route('admin.bookings.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load([
            'user',
            'flight.airline',
            'flight.aircraft',
            'flight.departureAirport',
            'flight.arrivalAirport',
            'passengers',
            'payments'
        ]);
        
        $title = 'Detail Booking ' . $booking->booking_code . ' - Travelo Admin';
        
        return view('admin.bookings.show', compact('booking', 'title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        return redirect()->route('admin.bookings.show', $booking)
            ->with('info', 'Gunakan aksi di halaman detail untuk mengubah status booking.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled'
        ]);
        
        $booking->update($validated);
        
        $statusText = [
            'pending' => 'menunggu',
            'confirmed' => 'dikonfirmasi', 
            'cancelled' => 'dibatalkan'
        ];
        
        return redirect()->route('admin.bookings.index')
            ->with('success', "Pemesanan berhasil {$statusText[$validated['status']]}!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Soft delete atau hard delete tergantung kebutuhan
        $booking->delete();
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Pemesanan berhasil dihapus!');
    }
}
