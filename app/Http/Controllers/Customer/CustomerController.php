<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Airport;
use App\Models\Airline;
use App\Models\FlightClass;
use App\Models\Passenger;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display customer dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        $totalBookings = Booking::where('user_id', $user->id)->count();
        $pendingBookings = Booking::where('user_id', $user->id)->where('status', 'pending')->count();
        $confirmedBookings = Booking::where('user_id', $user->id)->where('status', 'confirmed')->count();
        $recentBookings = Booking::with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
                                ->where('user_id', $user->id)
                                ->latest()
                                ->take(5)
                                ->get();

        return view('customer.dashboard', [
            'title' => 'Customer Dashboard',
            'name' => 'Customer',
            'totalBookings' => $totalBookings,
            'pendingBookings' => $pendingBookings,
            'confirmedBookings' => $confirmedBookings,
            'recentBookings' => $recentBookings
        ]);
    }

    /**
     * Display flight search page
     */
    public function searchFlights()
    {
        $airports = Airport::all();
        $airlines = Airline::all();
        
        return view('customer.search-flights', [
            'title' => 'Cari Penerbangan',
            'name' => 'Customer',
            'airports' => $airports,
            'airlines' => $airlines
        ]);
    }

    /**
     * Process flight search
     */
    public function processSearch(Request $request)
    {
        $request->validate([
            'departure_airport_id' => 'required|exists:airports,id',
            'arrival_airport_id' => 'required|exists:airports,id',
            'departure_date' => 'required|date|after_or_equal:today',
            'passengers' => 'required|integer|min:1|max:9',
        ]);

        $flights = Flight::with(['airline', 'departureAirport', 'arrivalAirport', 'aircraft'])
            ->where('departure_airport_id', $request->departure_airport_id)
            ->where('arrival_airport_id', $request->arrival_airport_id)
            ->whereDate('departure_time', $request->departure_date)
            ->get();

        // Filter flights that have available seats
        $flights = $flights->filter(function($flight) use ($request) {
            $totalAvailable = $flight->available_economy_seats + $flight->available_business_seats + $flight->available_first_class_seats;
            return $totalAvailable >= $request->passengers;
        });

        return view('customer.flight-results', [
            'title' => 'Flight Results',
            'name' => 'Customer',
            'flights' => $flights,
            'request' => $request
        ]);
    }

    /**
     * Show flight booking form
     */
    public function bookFlight(Flight $flight, Request $request)
    {
        $passengers = $request->get('passengers', 1);
        $flight_class_id = $request->get('flight_class_id');
        
        // Create a simple flight class object based on the price selection
        $flight_class = null;
        if ($flight_class_id == 1) {
            $flight_class = (object) [
                'id' => 1,
                'class_name' => 'Economy',
                'price' => $flight->economy_price
            ];
        } elseif ($flight_class_id == 2) {
            $flight_class = (object) [
                'id' => 2,
                'class_name' => 'Business', 
                'price' => $flight->business_price
            ];
        } elseif ($flight_class_id == 3) {
            $flight_class = (object) [
                'id' => 3,
                'class_name' => 'First',
                'price' => $flight->first_class_price
            ];
        }
        
        return view('customer.book-flight', [
            'title' => 'Book Flight',
            'name' => 'Customer',
            'flight' => $flight,
            'passengers' => $passengers,
            'flight_class' => $flight_class
        ]);
    }

    /**
     * Process flight booking
     */
    public function processBooking(Request $request)
    {
        $request->validate([
            'flight_id' => 'required|exists:flights,id',
            'flight_class_id' => 'required|in:1,2,3',
            'passengers' => 'required|array|min:1',
            'passengers.*.name' => 'required|string|max:255',
            'passengers.*.phone' => 'required|string|max:15',
            'passengers.*.email' => 'nullable|email',
        ]);

        DB::beginTransaction();
        
        try {
            $flight = Flight::findOrFail($request->flight_id);
            $flightClassId = (int) $request->flight_class_id;
            $passengerCount = count($request->passengers);
            
            // Determine class name and price based on flight_class_id
            $className = '';
            $classPrice = 0;
            $availableSeats = 0;
            
            switch ($flightClassId) {
                case 1:
                    $className = 'economy';
                    $classPrice = $flight->economy_price;
                    $availableSeats = $flight->available_economy_seats;
                    break;
                case 2:
                    $className = 'business';
                    $classPrice = $flight->business_price;
                    $availableSeats = $flight->available_business_seats;
                    break;
                case 3:
                    $className = 'first';
                    $classPrice = $flight->first_class_price;
                    $availableSeats = $flight->available_first_class_seats;
                    break;
                default:
                    return back()->with('error', 'Invalid flight class selected');
            }
            
            // Check available seats
            if ($availableSeats < $passengerCount) {
                return back()->with('error', 'Not enough available seats');
            }
            
            // Create booking
            $booking = Booking::create([
                'user_id' => Auth::id(),
                'flight_id' => $request->flight_id,
                'flight_class_id' => $flightClassId,
                'passengers_count' => $passengerCount,
                'total_price' => $classPrice * $passengerCount,
                'status' => 'pending',
                'booking_code' => $this->generateBookingCode(),
            ]);
            
            // Create passengers
            foreach ($request->passengers as $passengerData) {
                Passenger::create([
                    'booking_id' => $booking->id,
                    'name' => $passengerData['name'],
                    'phone' => $passengerData['phone'],
                    'email' => $passengerData['email'] ?? null,
                ]);
            }
            
            // Update available seats based on class
            switch ($flightClassId) {
                case 1:
                    $flight->decrement('available_economy_seats', $passengerCount);
                    break;
                case 2:
                    $flight->decrement('available_business_seats', $passengerCount);
                    break;
                case 3:
                    $flight->decrement('available_first_class_seats', $passengerCount);
                    break;
            }
            
            DB::commit();
            
            return redirect()->route('customer.payment', $booking->id)->with('success', 'Pemesanan berhasil dibuat!');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Pemesanan gagal: ' . $e->getMessage());
        }
    }

    /**
     * Show payment page
     */
    public function payment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $booking->load(['flight', 'passengers']);
        
        return view('customer.payment', [
            'title' => 'Payment',
            'name' => 'Customer',
            'booking' => $booking
        ]);
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request, Booking $booking)
    {
        $request->validate([
            'payment_method' => 'required|in:credit_card,bank_transfer,e_wallet',
        ]);

        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        DB::beginTransaction();
        
        try {
            // Create payment record
            $payment = Payment::create([
                'booking_id' => $booking->id,
                'payment_code' => Payment::generatePaymentCode(),
                'amount' => $booking->total_price,
                'method' => $request->payment_method,
                'status' => 'success',
                'payment_date' => now(),
                'expires_at' => now()->addHours(24),
            ]);

            // Update booking status
            $booking->update(['status' => 'confirmed']);

            DB::commit();

            return redirect()->route('customer.booking-confirmation', $booking->id)->with('success', 'Payment successful!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    /**
     * Show booking confirmation
     */
    public function bookingConfirmation(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers', 'payment']);
        
        return view('customer.booking-confirmation', [
            'title' => 'Booking Confirmation',
            'name' => 'Customer',
            'booking' => $booking
        ]);
    }

    /**
     * Show my bookings
     */
    public function myBookings()
    {
        $bookings = Booking::with(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport'])
                          ->where('user_id', Auth::id())
                          ->latest()
                          ->paginate(10);
        
        return view('customer.my-bookings', [
            'title' => 'Pemesanan Saya',
            'name' => 'Customer',
            'bookings' => $bookings
        ]);
    }

    /**
     * Show booking details
     */
    public function bookingDetails(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }
        
        $booking->load(['flight.airline', 'flight.departureAirport', 'flight.arrivalAirport', 'passengers', 'payment']);
        
        return view('customer.booking-details', [
            'title' => 'Booking Details',
            'name' => 'Customer',
            'booking' => $booking
        ]);
    }

    /**
     * Cancel booking
     */
    public function cancelBooking(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        if ($booking->status === 'cancelled') {
            return back()->with('error', 'Booking is already cancelled');
        }

        DB::beginTransaction();
        
        try {
            // Update booking status
            $booking->update(['status' => 'cancelled']);
            
            // Return available seats based on flight class
            switch ($booking->flight_class_id) {
                case 1:
                    $booking->flight->increment('available_economy_seats', $booking->passengers_count);
                    break;
                case 2:
                    $booking->flight->increment('available_business_seats', $booking->passengers_count);
                    break;
                case 3:
                    $booking->flight->increment('available_first_class_seats', $booking->passengers_count);
                    break;
            }
            
            DB::commit();
            
            return back()->with('success', 'Pemesanan berhasil dibatalkan');
            
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal membatalkan pemesanan');
        }
    }

    /**
     * Generate unique booking code
     */
    private function generateBookingCode()
    {
        do {
            $code = 'BK' . date('Ymd') . strtoupper(substr(md5(uniqid()), 0, 6));
        } while (Booking::where('booking_code', $code)->exists());
        
        return $code;
    }

    /**
     * Generate unique transaction ID
     */
    private function generateTransactionId()
    {
        do {
            $id = 'TXN' . date('YmdHis') . rand(1000, 9999);
        } while (Payment::where('transaction_id', $id)->exists());
        
        return $id;
    }
}
