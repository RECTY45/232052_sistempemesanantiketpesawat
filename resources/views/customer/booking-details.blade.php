@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-2">Booking Details</h2>
                        <p class="text-muted mb-0">Complete information about your flight booking</p>
                    </div>
                    <div>
                        <a href="{{ route('customer.my-bookings') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Bookings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <!-- Booking Status -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">Booking {{ $booking->booking_code }}</h5>
                                <p class="text-muted mb-0">Booked on {{ $booking->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div class="col-md-4 text-md-right">
                                @if($booking->status === 'confirmed')
                                    <span class="badge badge-success badge-lg">Confirmed</span>
                                @elseif($booking->status === 'pending')
                                    <span class="badge badge-warning badge-lg">Pending Payment</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge badge-secondary badge-lg">Cancelled</span>
                                @else
                                    <span class="badge badge-info badge-lg">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flight Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-plane mr-2"></i>Flight Information</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Flight Details</h6>
                                <p class="mb-1"><strong>{{ $booking->flight->airline->name }}</strong></p>
                                <p class="mb-1">Flight {{ $booking->flight->flight_number }}</p>
                                <p class="mb-1">{{ $booking->flight->aircraft->model }}</p>
                                <p class="mb-0">{{ $booking->flight_class_name }} Class</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Schedule</h6>
                                <p class="mb-1"><strong>Date:</strong>
                                    {{ $booking->flight->departure_time->format('l, M d, Y') }}</p>
                                <p class="mb-1"><strong>Departure:</strong>
                                    {{ $booking->flight->departure_time->format('H:i') }}</p>
                                <p class="mb-0"><strong>Arrival:</strong>
                                    {{ $booking->flight->arrival_time->format('H:i') }}</p>
                            </div>
                        </div>

                        <hr>

                        <!-- Route -->
                        <div class="row text-center">
                            <div class="col-5">
                                <div class="airport-info">
                                    <h5 class="mb-1">{{ $booking->flight->departureAirport->code }}</h5>
                                    <p class="mb-1">{{ $booking->flight->departureAirport->name }}</p>
                                    <p class="mb-0 text-muted">{{ $booking->flight->departureAirport->city }}</p>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                <div class="flight-arrow">
                                    <i class="fas fa-plane fa-2x text-primary"></i>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="airport-info">
                                    <h5 class="mb-1">{{ $booking->flight->arrivalAirport->code }}</h5>
                                    <p class="mb-1">{{ $booking->flight->arrivalAirport->name }}</p>
                                    <p class="mb-0 text-muted">{{ $booking->flight->arrivalAirport->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passenger Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-users mr-2"></i>Passengers ({{ $booking->passengers_count }})</h6>
                    </div>
                    <div class="card-body">
                        @foreach($booking->passengers as $index => $passenger)
                            <div
                                class="passenger-item {{ $index < $booking->passengers->count() - 1 ? 'mb-3 pb-3 border-bottom' : '' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="text-primary">Passenger {{ $index + 1 }}</h6>
                                        <p class="mb-1"><strong>{{ $passenger->name }}</strong></p>
                                        <p class="mb-0 text-muted">Phone: {{ $passenger->phone }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        @if($passenger->email)
                                            <br>
                                            <p class="mb-0 text-muted">Email: {{ $passenger->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                @if($booking->payment)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-credit-card mr-2"></i>Payment Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Transaction Details</h6>
                                    <p class="mb-1"><strong>Payment Code:</strong> {{ $booking->payment->payment_code }}</p>
                                    <p class="mb-1"><strong>Payment Method:</strong>
                                        {{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</p>
                                    <p class="mb-0"><strong>Payment Date:</strong>
                                        {{ $booking->payment->payment_date->format('M d, Y H:i') }}</p>
                                </div>
                                <div class="col-md-6">
                                    <h6>Amount</h6>
                                    <h4 class="text-success">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</h4>
                                    <span class="badge badge-success">{{ ucfirst($booking->payment->status) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center">
                            <h6 class="text-warning">Payment Pending</h6>
                            <p class="text-muted">This booking is waiting for payment confirmation.</p>
                            @if($booking->status === 'pending')
                                <a href="{{ route('customer.payment', $booking->id) }}" class="btn btn-primary">
                                    <i class="fas fa-credit-card mr-2"></i> Complete Payment
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <!-- Action Panel -->
            <div class="col-lg-4">
                <div class="card position-sticky" style="top: 20px;">
                    <div class="card-header">
                        <h6 class="mb-0">Booking Actions</h6>
                    </div>
                    <div class="card-body">
                        <!-- Quick Info -->
                        <div class="quick-info mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Total Amount:</span>
                                <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Status:</span>
                                <span>{{ ucfirst($booking->status) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Passengers:</span>
                                <span>{{ $booking->passengers_count }}</span>
                            </div>
                        </div>

                        <hr>

                        <!-- Actions -->
                        <div class="actions">
                            @if($booking->status === 'pending')
                                <a href="{{ route('customer.payment', $booking->id) }}" class="btn btn-success btn-block mb-2">
                                    <i class="fas fa-credit-card mr-2"></i> Complete Payment
                                </a>
                            @endif

                            @if($booking->status === 'confirmed')
                                <button class="btn btn-info btn-block mb-2" onclick="printTicket()">
                                    <i class="fas fa-print mr-2"></i> Print Ticket
                                </button>
                            @endif

                            @if($booking->status === 'pending' || $booking->status === 'confirmed')
                                <button class="btn btn-outline-danger btn-block mb-2"
                                    onclick="cancelBooking({{ $booking->id }}, '{{ $booking->booking_code }}')">
                                    <i class="fas fa-times mr-2"></i> Cancel Booking
                                </button>
                            @endif

                            <a href="{{ route('customer.my-bookings') }}" class="btn btn-outline-secondary btn-block">
                                <i class="fas fa-list mr-2"></i> All Bookings
                            </a>
                        </div>

                        <hr>

                        <!-- Support -->
                        <div class="support-info">
                            <h6 class="mb-2">Need Help?</h6>
                            <p class="small text-muted mb-2">Contact our customer service for assistance</p>
                            <button class="btn btn-outline-primary btn-sm btn-block" data-toggle="modal"
                                data-target="#supportModal">
                                <i class="fas fa-headset mr-2"></i> Contact Support
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cancel Booking</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to cancel booking <strong id="cancelBookingCode"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        This action cannot be undone. Refund policies may apply.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keep Booking</button>
                    <form id="cancelBookingForm" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger">Cancel Booking</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Customer Support</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
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

    <style>
        .airport-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }

        .flight-arrow {
            position: relative;
        }

        .passenger-item {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .badge-lg {
            font-size: 1.1em;
            padding: 0.6em 1em;
        }

        .quick-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
    </style>

    <script>
        function cancelBooking(bookingId, bookingCode) {
            document.getElementById('cancelBookingCode').textContent = bookingCode;
            document.getElementById('cancelBookingForm').action = `/customer/cancel-booking/${bookingId}`;
            $('#cancelBookingModal').modal('show');
        }

        function printTicket() {
            window.print();
        }
    </script>
@endsection
