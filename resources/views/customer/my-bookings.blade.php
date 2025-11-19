@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Pemesanan Saya</h2>
                    <a href="{{ route('customer.search-flights') }}" class="btn btn-primary">
                        <i class="fas fa-plus mr-2"></i> Pesan Penerbangan Baru
                    </a>
                </div>
            </div>
        </div>

        @if($bookings->count() > 0)
            <div class="row">
                @foreach($bookings as $booking)
                    <div class="col-lg-6 col-12 mb-4">
                        <div class="card booking-card h-100">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $booking->booking_code }}</h6>
                                    <small class="text-muted">Booked on {{ $booking->created_at->format('M d, Y') }}</small>
                                </div>
                                <div>
                                    @if($booking->status === 'confirmed')
                                        <span class="badge badge-success">Confirmed</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="badge badge-secondary">Cancelled</span>
                                    @else
                                        <span class="badge badge-info">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Flight Information -->
                                <div class="flight-info mb-3">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-plane text-primary mr-2"></i>
                                        <strong>{{ $booking->flight->airline->name }} {{ $booking->flight->flight_number }}</strong>
                                    </div>

                                    <div class="route-info">
                                        <div class="row text-center">
                                            <div class="col-5">
                                                <h6 class="mb-0">{{ $booking->flight->departure_time->format('H:i') }}</h6>
                                                <small
                                                    class="text-muted">{{ $booking->flight->departure_airport->city }}</small><br>
                                                <small class="text-muted">{{ $booking->flight->departure_airport->code }}</small>
                                            </div>
                                            <div class="col-2 d-flex align-items-center justify-content-center">
                                                <i class="fas fa-arrow-right text-muted"></i>
                                            </div>
                                            <div class="col-5">
                                                <h6 class="mb-0">{{ $booking->flight->arrival_time->format('H:i') }}</h6>
                                                <small class="text-muted">{{ $booking->flight->arrival_airport->city }}</small><br>
                                                <small class="text-muted">{{ $booking->flight->arrival_airport->code }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i
                                                class="fas fa-calendar mr-1"></i>{{ $booking->flight->departure_time->format('l, M d, Y') }}
                                        </small>
                                    </div>
                                </div>

                                <!-- Booking Details -->
                                <div class="booking-details">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Class</small><br>
                                            <strong>{{ ucfirst($booking->flight_class->class_name) }}</strong>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Passengers</small><br>
                                            <strong>{{ $booking->passengers_count }}</strong>
                                        </div>
                                    </div>

                                    <div class="mt-2">
                                        <small class="text-muted">Total Amount</small><br>
                                        <h6 class="text-primary">Rp {{ number_format($booking->total_amount, 0, ',', '.') }}</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="btn-group w-100" role="group">
                                    <a href="{{ route('customer.booking-details', $booking->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-eye mr-1"></i> Details
                                    </a>
                                    @if($booking->status === 'pending' || $booking->status === 'confirmed')
                                        <button type="button" class="btn btn-outline-danger"
                                            onclick="cancelBooking({{ $booking->id }}, '{{ $booking->booking_code }}')">
                                            <i class="fas fa-times mr-1"></i> Cancel
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="row">
                <div class="col-12 d-flex justify-content-center">
                    {{ $bookings->links() }}
                </div>
            </div>
        @else
            <!-- No Bookings -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-plane fa-4x text-muted mb-4"></i>
                            <h4>No Bookings Yet</h4>
                            <p class="text-muted mb-4">You haven't made any flight bookings. Start planning your trip!</p>
                            <a href="{{ route('customer.search-flights') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-search mr-2"></i> Search Flights
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Cancel Booking Modal -->
    <div class="modal fade" id="cancelBookingModal" tabindex="-1" role="dialog" aria-labelledby="cancelBookingModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelBookingModalLabel">Cancel Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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

    <style>
        .booking-card {
            border: 1px solid #e0e0e0;
            transition: box-shadow 0.3s ease;
        }

        .booking-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .route-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }
    </style>

    <script>
        function cancelBooking(bookingId, bookingCode) {
            document.getElementById('cancelBookingCode').textContent = bookingCode;
            document.getElementById('cancelBookingForm').action = `/customer/cancel-booking/${bookingId}`;
            $('#cancelBookingModal').modal('show');
        }
    </script>
@endsection