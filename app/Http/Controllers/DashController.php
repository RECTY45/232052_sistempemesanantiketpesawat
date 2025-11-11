<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Airline;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;

class DashController extends Controller
{
    public function dash(){
        $stats = [
            'users' => User::count(),
            'airlines' => Airline::count(),
            'airports' => Airport::count(),
            'flights' => Flight::count(),
            'bookings' => Booking::count(),
            'payments_success' => Payment::where('status', 'success')->count(),
            'total_revenue' => Payment::where('status', 'success')->sum('amount'),
        ];

        // Recent flights
        $recentFlights = Flight::with(['airline', 'departureAirport', 'arrivalAirport'])
            ->orderBy('departure_time', 'desc')
            ->limit(5)
            ->get();

        // Recent bookings
        $recentBookings = Booking::with(['user', 'flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard.dash',[
            'title' => 'Travelo | Dashboard',
            'name' =>  'Travelo',
            'stats' => $stats,
            'recentFlights' => $recentFlights,
            'recentBookings' => $recentBookings,
        ]);
    }
}
