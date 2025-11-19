@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Welcome, {{ auth()->user()->name }}!</h2>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $totalBookings }}</h4>
                            <p class="mb-0">Total Bookings</p>
                        </div>
                        <div>
                            <i class="fas fa-plane fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $pendingBookings }}</h4>
                            <p class="mb-0">Pending Bookings</p>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4>{{ $confirmedBookings }}</h4>
                            <p class="mb-0">Confirmed Bookings</p>
                        </div>
                        <div>
                            <i class="fas fa-check fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('customer.search-flights') }}" class="btn btn-light btn-sm">Book Now</a>
                            <p class="mb-0 mt-2">Quick Booking</p>
                        </div>
                        <div>
                            <i class="fas fa-plus fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('customer.search-flights') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-2"></i> Search Flights
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('customer.my-bookings') }}" class="btn btn-info btn-block">
                                <i class="fas fa-list mr-2"></i> My Bookings
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#checkInModal">
                                <i class="fas fa-check-circle mr-2"></i> Check-in
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-success btn-block" data-toggle="modal" data-target="#supportModal">
                                <i class="fas fa-headset mr-2"></i> Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bookings</h5>
                    <a href="{{ route('customer.my-bookings') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body">
                    @if($recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Booking Code</th>
                                        <th>Flight</th>
                                        <th>Route</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td><strong>{{ $booking->booking_code }}</strong></td>
                                            <td>{{ $booking->flight->airline->name }} {{ $booking->flight->flight_number }}</td>
                                            <td>{{ $booking->flight->departure_airport->city }} → {{ $booking->flight->arrival_airport->city }}</td>
                                            <td>{{ $booking->flight->departure_time->format('M d, Y H:i') }}</td>
                                            <td>
                                                @if($booking->status === 'confirmed')
                                                    <span class="badge badge-success">Confirmed</span>
                                                @elseif($booking->status === 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('customer.booking-details', $booking->id) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No bookings yet</h5>
                            <p class="text-muted">Start your journey by booking your first flight!</p>
                            <a href="{{ route('customer.search-flights') }}" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i> Search Flights
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Check-in Modal -->
<div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkInModalLabel">Online Check-in</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="bookingCode">Booking Code</label>
                        <input type="text" class="form-control" id="bookingCode" placeholder="Enter your booking code">
                    </div>
                    <div class="form-group">
                        <label for="lastName">Last Name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Enter passenger last name">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary">Check-in</button>
            </div>
        </div>
    </div>
</div>

<!-- Support Modal -->
<div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supportModalLabel">Customer Support</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Contact Information:</h6>
                <p><strong>Phone:</strong> +62-800-1234-5678</p>
                <p><strong>Email:</strong> support@airline.com</p>
                <p><strong>Hours:</strong> 24/7</p>
                
                <h6 class="mt-4">Quick Help:</h6>
                <div class="list-group">
                    <a href="#" class="list-group-item list-group-item-action">Change Flight</a>
                    <a href="#" class="list-group-item list-group-item-action">Cancel Booking</a>
                    <a href="#" class="list-group-item list-group-item-action">Refund Request</a>
                    <a href="#" class="list-group-item list-group-item-action">Special Assistance</a>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
