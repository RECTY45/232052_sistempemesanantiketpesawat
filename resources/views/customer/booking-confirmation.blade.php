@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-2">Konfirmasi Pemesanan</h2>
                        <p class="text-muted mb-0">Penerbangan Anda telah berhasil dipesan!</p>
                    </div>
                    <div class="text-right">
                        <div class="alert alert-success mb-0">
                            <i class="fas fa-check-circle mr-2"></i>
                            <strong>Pemesanan Dikonfirmasi</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Booking Details Card -->
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <h5 class="mb-1">Konfirmasi Pemesanan</h5>
                                <p class="mb-0">Kode Pemesanan: <strong>{{ $booking->booking_code }}</strong></p>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <h4 class="mb-0">Rp {{ number_format($booking->total_price, 0, ',', '.') }}</h4>
                                <small>Total Dibayar</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Flight Information -->
                        <div class="row">
                            <div class="col-md-6">
                                <h6><i class="fas fa-plane mr-2 text-primary"></i>Flight Information</h6>
                                <div class="flight-details">
                                    <p class="mb-1"><strong>{{ $booking->flight->airline->name }}</strong></p>
                                    <p class="mb-1">Flight {{ $booking->flight->flight_number }}</p>
                                    <p class="mb-1">{{ $booking->flight->aircraft->model }}</p>
                                    <p class="mb-0">{{ $booking->flight_class_name }}</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6><i class="fas fa-calendar mr-2 text-primary"></i>Schedule</h6>
                                <div class="schedule-details">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Date:</span>
                                        <span>{{ $booking->flight->departure_time->format('l, M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Departure:</span>
                                        <span>{{ $booking->flight->departure_time->format('H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Arrival:</span>
                                        <span>{{ $booking->flight->arrival_time->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Route Information -->
                        <h6><i class="fas fa-route mr-2 text-primary"></i>Route Details</h6>
                        <div class="row text-center">
                            <div class="col-5">
                                <div class="departure-info">
                                    <h5 class="mb-1">{{ $booking->flight->departureAirport->code }}</h5>
                                    <p class="mb-1">{{ $booking->flight->departureAirport->name }}</p>
                                    <p class="mb-0 text-muted">{{ $booking->flight->departureAirport->city }}</p>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plane fa-2x text-muted"></i>
                            </div>
                            <div class="col-5">
                                <div class="arrival-info">
                                    <h5 class="mb-1">{{ $booking->flight->arrivalAirport->code }}</h5>
                                    <p class="mb-1">{{ $booking->flight->arrivalAirport->name }}</p>
                                    <p class="mb-0 text-muted">{{ $booking->flight->arrivalAirport->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passengers Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-users mr-2"></i>Passenger Information</h6>
                    </div>
                    <div class="card-body">
                        @foreach($booking->passengers as $index => $passenger)
                            <div
                                class="passenger-card {{ $index < $booking->passengers->count() - 1 ? 'mb-3 pb-3 border-bottom' : '' }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6>Passenger {{ $index + 1 }}</h6>
                                        <p class="mb-1"><strong>{{ $passenger->name }}</strong></p>
                                        <p class="mb-0 text-muted">{{ $passenger->phone }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        @if($passenger->email)
                                            <br>
                                            <p class="mb-0 text-muted">{{ $passenger->email }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Information -->
                @if($booking->payment)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-credit-card mr-2"></i>Payment Information</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Payment Code:</span>
                                        <span><strong>{{ $booking->payment->payment_code }}</strong></span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Payment Method:</span>
                                        <span>{{ ucfirst(str_replace('_', ' ', $booking->payment->method)) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Payment Date:</span>
                                        <span>{{ $booking->payment->payment_date->format('M d, Y H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span>Status:</span>
                                        <span class="badge badge-success">{{ ucfirst($booking->payment->status) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="card">
                    <div class="card-body text-center">
                        <h6 class="mb-3">What's Next?</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('customer.booking-details', $booking->id) }}"
                                    class="btn btn-primary btn-block">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('customer.booking-pdf', $booking->id) }}" class="btn btn-info btn-block" target="_blank" rel="noopener">
                                    <i class="fas fa-file-pdf mr-2"></i> Unduh PDF
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('customer.search-flights') }}" class="btn btn-outline-primary btn-block">
                                    <i class="fas fa-search mr-2"></i> Book Another
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Important Information -->
                <div class="card mt-4">
                    <div class="card-body">
                        <h6 class="text-warning mb-3"><i class="fas fa-exclamation-triangle mr-2"></i>Important Information
                        </h6>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Please arrive at the airport at
                                least 2 hours before domestic flights</li>
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Online check-in will be
                                available 24 hours before departure</li>
                            <li class="mb-2"><i class="fas fa-check text-success mr-2"></i> Bring a valid ID or passport for
                                identification</li>
                            <li class="mb-0"><i class="fas fa-check text-success mr-2"></i> Contact customer service if you
                                need to make changes</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .flight-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .schedule-details {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 10px;
        }

        .passenger-card {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        @media print {
            .card-header {
                background-color: #000 !important;
                color: #fff !important;
            }

            .btn {
                display: none !important;
            }

            .navbar,
            .sidebar {
                display: none !important;
            }
        }
    </style>
@endsection
