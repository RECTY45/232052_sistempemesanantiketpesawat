@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Flight Information -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">{{ $flight->airline->name }} {{ $flight->flight_number }}</h5>
                                <p class="mb-0">
                                    <strong>{{ $flight->departureAirport->city }}</strong> →
                                    <strong>{{ $flight->arrivalAirport->city }}</strong> |
                                    {{ $flight->departure_time->format('M d, Y H:i') }} |
                                    {{ $passengers }} {{ $passengers == 1 ? 'Passenger' : 'Passengers' }}
                                    @if($flight_class)
                                        | {{ ucfirst($flight_class->class_name) }} Class
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4 text-md-right">
                                @if($flight_class)
                                    <h4 class="mb-0">Rp {{ number_format($flight_class->price * $passengers, 0, ',', '.') }}
                                    </h4>
                                    <small>Total for {{ $passengers }}
                                        {{ $passengers == 1 ? 'passenger' : 'passengers' }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('customer.process-booking') }}" method="POST">
            @csrf
            <input type="hidden" name="flight_id" value="{{ $flight->id }}">
            <input type="hidden" name="flight_class_id" value="{{ $flight_class->id ?? '' }}">

            <div class="row">
                <!-- Passenger Information -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Passenger Information</h5>
                        </div>
                        <div class="card-body">
                            @for($i = 0; $i < $passengers; $i++)
                                <div class="passenger-form mb-4 pb-3 {{ $i < $passengers - 1 ? 'border-bottom' : '' }}">
                                    <h6 class="mb-3">Passenger {{ $i + 1 }}</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="passengers[{{ $i }}][name]" class="form-label">Full Name <span
                                                    class="text-danger">*</span></label>
                                            <input type="text"
                                                class="form-control @error('passengers.' . $i . '.name') is-invalid @enderror"
                                                id="passengers[{{ $i }}][name]" name="passengers[{{ $i }}][name]"
                                                value="{{ old('passengers.' . $i . '.name') }}" required>
                                            @error('passengers.' . $i . '.name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="form-text text-muted">As written in ID/Passport</small>
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="passengers[{{ $i }}][phone]" class="form-label">Phone Number <span
                                                    class="text-danger">*</span></label>
                                            <input type="tel"
                                                class="form-control @error('passengers.' . $i . '.phone') is-invalid @enderror"
                                                id="passengers[{{ $i }}][phone]" name="passengers[{{ $i }}][phone]"
                                                value="{{ old('passengers.' . $i . '.phone') }}" required>
                                            @error('passengers.' . $i . '.phone')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="passengers[{{ $i }}][email]" class="form-label">Email (Optional)</label>
                                            <input type="email"
                                                class="form-control @error('passengers.' . $i . '.email') is-invalid @enderror"
                                                id="passengers[{{ $i }}][email]" name="passengers[{{ $i }}][email]"
                                                value="{{ old('passengers.' . $i . '.email') }}">
                                            @error('passengers.' . $i . '.email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <!-- Terms and Conditions -->
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="terms" required>
                                <label class="form-check-label" for="terms">
                                    I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and
                                        Conditions</a> and <a href="#" data-toggle="modal"
                                        data-target="#privacyModal">Privacy Policy</a> <span class="text-danger">*</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Summary -->
                <div class="col-lg-4">
                    <div class="card position-sticky" style="top: 20px;">
                        <div class="card-header">
                            <h5 class="mb-0">Booking Summary</h5>
                        </div>
                        <div class="card-body">
                            <!-- Flight Details -->
                            <div class="mb-3">
                                <h6>Flight Details</h6>
                                <div class="small">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Airline:</span>
                                        <span>{{ $flight->airline->name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Flight:</span>
                                        <span>{{ $flight->flight_number }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Aircraft:</span>
                                        <span>{{ $flight->aircraft->model }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Date:</span>
                                        <span>{{ $flight->departure_time->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Departure:</span>
                                        <span>{{ $flight->departure_time->format('H:i') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Arrival:</span>
                                        <span>{{ $flight->arrival_time->format('H:i') }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <!-- Price Breakdown -->
                            <div class="mb-3">
                                <h6>Price Breakdown</h6>
                                <div class="small">
                                    @if($flight_class)
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>{{ ucfirst($flight_class->class_name) }} Class x {{ $passengers }}</span>
                                            <span>Rp {{ number_format($flight_class->price * $passengers, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between mb-1">
                                            <span>Taxes & Fees</span>
                                            <span>Included</span>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <hr>

                            <!-- Total -->
                            @if($flight_class)
                                <div class="d-flex justify-content-between mb-3">
                                    <h6>Total Amount</h6>
                                    <h6>Rp {{ number_format($flight_class->price * $passengers, 0, ',', '.') }}</h6>
                                </div>
                            @endif

                            <!-- Book Button -->
                            <button type="submit" class="btn btn-success btn-block btn-lg">
                                <i class="fas fa-plane mr-2"></i> Book Flight
                            </button>

                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-lock mr-1"></i> Secure booking
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Terms Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>1. Booking Terms</h6>
                    <p>All bookings are subject to availability and confirmation. Prices are subject to change without
                        notice.</p>

                    <h6>2. Payment</h6>
                    <p>Payment must be completed within 24 hours of booking confirmation.</p>

                    <h6>3. Cancellation</h6>
                    <p>Cancellation policies vary by airline and ticket type. Check your booking details for specific terms.
                    </p>

                    <h6>4. Check-in</h6>
                    <p>Online check-in is available 24 hours before departure. Airport check-in closes 2 hours before
                        domestic flights and 3 hours before international flights.</p>

                    <h6>5. Liability</h6>
                    <p>Our liability is limited as per airline terms and conditions.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Privacy Modal -->
    <div class="modal fade" id="privacyModal" tabindex="-1" role="dialog" aria-labelledby="privacyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Data Collection</h6>
                    <p>We collect personal information necessary for flight booking and travel purposes.</p>

                    <h6>Data Usage</h6>
                    <p>Your data is used for booking confirmation, communication, and improving our services.</p>

                    <h6>Data Protection</h6>
                    <p>We implement appropriate security measures to protect your personal information.</p>

                    <h6>Data Sharing</h6>
                    <p>We may share your data with airlines and relevant authorities as required for travel purposes.</p>

                    <h6>Your Rights</h6>
                    <p>You have the right to access, correct, or delete your personal data. Contact us for any privacy
                        concerns.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">I Understand</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Auto-fill first passenger with logged-in user data
            if (document.querySelector('input[name="passengers[0][name]"]')) {
                // You can auto-fill with user data here if needed
                // document.querySelector('input[name="passengers[0][name]"]').value = '{{ auth()->user()->name }}';
            }
        });
    </script>
@endsection
