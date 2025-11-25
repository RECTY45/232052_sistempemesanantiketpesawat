@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <!-- Search Summary -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <h5 class="mb-1">Flight Search Results</h5>
                                <p class="mb-0">
                                    @php
                                        $departure = App\Models\Airport::find($request->departure_airport_id);
                                        $arrival = App\Models\Airport::find($request->arrival_airport_id);
                                    @endphp
                                    <strong>{{ $departure->city }}</strong> → <strong>{{ $arrival->city }}</strong> |
                                    {{ date('M d, Y', strtotime($request->departure_date)) }} |
                                    {{ $request->passengers }} {{ $request->passengers == 1 ? 'Passenger' : 'Passengers' }}
                                </p>
                            </div>
                            <div class="col-md-4 text-md-right">
                                <a href="{{ route('customer.search-flights') }}" class="btn btn-outline-primary">
                                    <i class="fas fa-search mr-1"></i> Modify Search
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flight Results -->
        @if($flights->count() > 0)
            <div class="row">
                <div class="col-12">
                    <h4 class="mb-3">Available Flights ({{ $flights->count() }} found)</h4>
                </div>
            </div>

            @foreach($flights as $flight)
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card flight-card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <!-- Airline Info -->
                                    <div class="col-lg-3 col-md-4 mb-3 mb-md-0">
                                        <div class="d-flex align-items-center">
                                            <div class="airline-logo mr-3">
                                                <i class="fas fa-plane fa-2x text-primary"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $flight->airline->name }}</h6>
                                                <small class="text-muted">{{ $flight->flight_number }}</small><br>
                                                <small class="text-muted">{{ $flight->aircraft->model }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Flight Times -->
                                    <div class="col-lg-4 col-md-4 mb-3 mb-md-0">
                                        <div class="row text-center">
                                            <div class="col-5">
                                                <h5 class="mb-0">{{ $flight->departure_time->format('H:i') }}</h5>
                                                <small class="text-muted">{{ $flight->departure_airport->code }}</small>
                                            </div>
                                            <div class="col-2">
                                                <i class="fas fa-plane text-muted"></i>
                                                <br>
                                                <small class="text-muted">
                                                    @php
                                                        $duration = $flight->departure_time->diffInMinutes($flight->arrival_time);
                                                        $hours = intval($duration / 60);
                                                        $minutes = $duration % 60;
                                                    @endphp
                                                    {{ $hours }}h {{ $minutes }}m
                                                </small>
                                            </div>
                                            <div class="col-5">
                                                <h5 class="mb-0">{{ $flight->arrival_time->format('H:i') }}</h5>
                                                <small class="text-muted">{{ $flight->arrival_airport->code }}</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Available Seats -->
                                    <div class="col-lg-2 col-md-2 mb-3 mb-md-0 text-center">
                                        <span class="badge badge-success badge-lg">
                                            @php
                                                $totalSeats = $flight->available_economy_seats + $flight->available_business_seats + $flight->available_first_class_seats;
                                            @endphp
                                            {{ $totalSeats }} seats
                                        </span>
                                    </div>

                                    <!-- Flight Classes & Prices -->
                                    <div class="col-lg-3 col-md-2">
                                        @foreach($flight->flight_classes as $flightClass)
                                            <div class="mb-2">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <small class="text-muted">{{ ucfirst($flightClass->class_name) }}</small>
                                                        <h6 class="mb-0">Rp {{ number_format($flightClass->price, 0, ',', '.') }}</h6>
                                                    </div>
                                                    <a href="{{ route('customer.book-flight', ['flight' => $flight->id, 'passengers' => $request->passengers, 'flight_class_id' => $flightClass->id]) }}"
                                                        class="btn btn-primary btn-sm">
                                                        Book
                                                    </a>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Flight Details Toggle -->
                                <div class="mt-3">
                                    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse"
                                        data-target="#flightDetails{{ $flight->id }}" aria-expanded="false">
                                        <i class="fas fa-info-circle mr-1"></i> Flight Details
                                    </button>

                                    <div class="collapse mt-2" id="flightDetails{{ $flight->id }}">
                                        <div class="card card-body bg-light">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6>Departure</h6>
                                                    <p class="mb-1">{{ $flight->departure_airport->name }}</p>
                                                    <p class="mb-1">{{ $flight->departure_airport->city }}</p>
                                                    <p class="mb-0 text-muted">{{ $flight->departure_time->format('M d, Y H:i') }}
                                                    </p>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6>Arrival</h6>
                                                    <p class="mb-1">{{ $flight->arrival_airport->name }}</p>
                                                    <p class="mb-1">{{ $flight->arrival_airport->city }}</p>
                                                    <p class="mb-0 text-muted">{{ $flight->arrival_time->format('M d, Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- No Flights Found -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-search fa-3x text-muted mb-3"></i>
                            <h4>No Flights Found</h4>
                            <p class="text-muted">Sorry, we couldn't find any flights matching your search criteria.</p>
                            <div class="mt-4">
                                <a href="{{ route('customer.search-flights') }}" class="btn btn-primary">
                                    <i class="fas fa-search mr-2"></i> Try Different Search
                                </a>
                            </div>

                            <!-- Suggestions -->
                            <div class="mt-4">
                                <h6>Suggestions:</h6>
                                <ul class="list-unstyled">
                                    <li>• Try different departure or arrival dates</li>
                                    <li>• Check if you have the correct airports selected</li>
                                    <li>• Consider nearby airports</li>
                                    <li>• Reduce the number of passengers if needed</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .flight-card {
            border: 1px solid #e0e0e0;
            transition: box-shadow 0.3s ease;
        }

        .flight-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .airline-logo {
            width: 50px;
            text-align: center;
        }

        .badge-lg {
            font-size: 0.9em;
            padding: 0.5em 0.75em;
        }
    </style>
@endsection