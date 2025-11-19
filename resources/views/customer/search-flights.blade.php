@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <h2 class="mb-4">Cari Penerbangan</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Pencarian Penerbangan</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.process-search') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="departure_airport_id" class="form-label">Dari</label>
                                    <select class="form-control @error('departure_airport_id') is-invalid @enderror"
                                        id="departure_airport_id" name="departure_airport_id" required>
                                        <option value="">Pilih Kota Keberangkatan</option>
                                        @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}" {{ old('departure_airport_id') == $airport->id ? 'selected' : '' }}>
                                                {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('departure_airport_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="arrival_airport_id" class="form-label">Ke</label>
                                    <select class="form-control @error('arrival_airport_id') is-invalid @enderror"
                                        id="arrival_airport_id" name="arrival_airport_id" required>
                                        <option value="">Pilih Kota Tujuan</option>
                                        @foreach($airports as $airport)
                                            <option value="{{ $airport->id }}" {{ old('arrival_airport_id') == $airport->id ? 'selected' : '' }}>
                                                {{ $airport->city }} ({{ $airport->code }}) - {{ $airport->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('arrival_airport_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="departure_date" class="form-label">Tanggal Keberangkatan</label>
                                    <input type="date" class="form-control @error('departure_date') is-invalid @enderror"
                                        id="departure_date" name="departure_date" value="{{ old('departure_date') }}"
                                        min="{{ date('Y-m-d') }}" required>
                                    @error('departure_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="passengers" class="form-label">Penumpang</label>
                                    <select class="form-control @error('passengers') is-invalid @enderror" id="passengers"
                                        name="passengers" required>
                                        @for($i = 1; $i <= 9; $i++)
                                            <option value="{{ $i }}" {{ old('passengers') == $i ? 'selected' : '' }}>
                                                {{ $i }} {{ $i == 1 ? 'Penumpang' : 'Penumpang' }}
                                            </option>
                                        @endfor
                                    </select>
                                    @error('passengers')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-search mr-2"></i> Cari Penerbangan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Popular Destinations -->
        <div class="row mt-5">
            <div class="col-12">
                <h4 class="mb-3">Popular Destinations</h4>
            </div>
        </div>

        <div class="row">
            @foreach($airports->take(6) as $airport)
                <div class="col-lg-4 col-md-6 mb-3">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-map-marker-alt fa-2x text-primary mb-2"></i>
                            <h5 class="card-title">{{ $airport->city }}</h5>
                            <p class="card-text">{{ $airport->name }}</p>
                            <small class="text-muted">{{ $airport->code }}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Airlines Partner -->
        @if($airlines->count() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="mb-3">Our Airline Partners</h4>
                </div>
            </div>

            <div class="row">
                @foreach($airlines as $airline)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <i class="fas fa-plane text-primary fa-2x mb-2"></i>
                                <h6 class="card-title">{{ $airline->name }}</h6>
                                <small class="text-muted">{{ $airline->code }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Prevent selecting same departure and arrival airport
            const departureSelect = document.getElementById('departure_airport_id');
            const arrivalSelect = document.getElementById('arrival_airport_id');

            function updateAirportOptions() {
                const departureValue = departureSelect.value;
                const arrivalValue = arrivalSelect.value;

                // Reset all options
                Array.from(arrivalSelect.options).forEach(option => {
                    option.disabled = false;
                });
                Array.from(departureSelect.options).forEach(option => {
                    option.disabled = false;
                });

                // Disable selected options in the other select
                if (departureValue) {
                    Array.from(arrivalSelect.options).forEach(option => {
                        if (option.value === departureValue) {
                            option.disabled = true;
                        }
                    });
                }

                if (arrivalValue) {
                    Array.from(departureSelect.options).forEach(option => {
                        if (option.value === arrivalValue) {
                            option.disabled = true;
                        }
                    });
                }
            }

            departureSelect.addEventListener('change', updateAirportOptions);
            arrivalSelect.addEventListener('change', updateAirportOptions);

            // Initial call
            updateAirportOptions();
        });
    </script>
@endsection