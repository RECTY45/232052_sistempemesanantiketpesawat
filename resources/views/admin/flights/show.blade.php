@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h2 class="mb-2">Detail Penerbangan</h2>
                        <p class="text-muted mb-0">Informasi lengkap tentang jadwal penerbangan</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-secondary me-2">
                            <i class="fas fa-arrow-left me-2"></i> Kembali
                        </a>
                        <a href="{{ route('admin.flights.edit', $flight->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i> Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Flight Information -->
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">
                            <i class="fas fa-plane me-2"></i>{{ $flight->airline->name }} {{ $flight->flight_number }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">Informasi Dasar</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Nomor Penerbangan:</strong></td>
                                        <td>{{ $flight->flight_number }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Maskapai:</strong></td>
                                        <td>{{ $flight->airline->name }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Pesawat:</strong></td>
                                        <td>{{ $flight->aircraft->model }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status:</strong></td>
                                        <td>
                                            @if($flight->status === 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @elseif($flight->status === 'cancelled')
                                                <span class="badge bg-danger">Dibatalkan</span>
                                            @else
                                                <span class="badge bg-secondary">{{ ucfirst($flight->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-primary">Jadwal</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <td><strong>Tanggal:</strong></td>
                                        <td>{{ $flight->departure_time->format('l, d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Waktu Keberangkatan:</strong></td>
                                        <td>{{ $flight->departure_time->format('H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Waktu Tiba:</strong></td>
                                        <td>{{ $flight->arrival_time->format('H:i') }} WIB</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Durasi:</strong></td>
                                        <td>{{ $flight->departure_time->diff($flight->arrival_time)->format('%H jam %I menit') }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Route Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-map-marker-alt me-2"></i>Rute Penerbangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-5">
                                <div class="airport-info">
                                    <h4 class="text-primary">{{ $flight->departureAirport->code }}</h4>
                                    <h6>{{ $flight->departureAirport->name }}</h6>
                                    <p class="text-muted mb-0">{{ $flight->departureAirport->city }}</p>
                                </div>
                            </div>
                            <div class="col-2 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plane fa-2x text-primary"></i>
                            </div>
                            <div class="col-5">
                                <div class="airport-info">
                                    <h4 class="text-primary">{{ $flight->arrivalAirport->code }}</h4>
                                    <h6>{{ $flight->arrivalAirport->name }}</h6>
                                    <p class="text-muted mb-0">{{ $flight->arrivalAirport->city }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Price Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0"><i class="fas fa-dollar-sign me-2"></i>Informasi Harga</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="price-info">
                                    <h6 class="text-success">Ekonomi</h6>
                                    <h5>Rp {{ number_format($flight->economy_price, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Per penumpang</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="price-info">
                                    <h6 class="text-warning">Bisnis</h6>
                                    <h5>Rp {{ number_format($flight->business_price, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Per penumpang</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="price-info">
                                    <h6 class="text-primary">First Class</h6>
                                    <h5>Rp {{ number_format($flight->first_class_price, 0, ',', '.') }}</h5>
                                    <small class="text-muted">Per penumpang</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Bookings -->
                @if($flight->bookings && $flight->bookings->count() > 0)
                    <div class="card">
                        <div class="card-header">
                            <h6 class="mb-0"><i class="fas fa-users me-2"></i>Pemesanan ({{ $flight->bookings->count() }})</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Kode Booking</th>
                                            <th>Penumpang</th>
                                            <th>Kelas</th>
                                            <th>Status</th>
                                            <th>Total</th>
                                            <th>Tanggal Pesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($flight->bookings as $booking)
                                            <tr>
                                                <td>
                                                    <a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-primary">
                                                        {{ $booking->booking_code }}
                                                    </a>
                                                </td>
                                                <td>{{ $booking->user->name }}</td>
                                                <td>{{ $booking->flight_class_name }}</td>
                                                <td>
                                                    @if($booking->status === 'confirmed')
                                                        <span class="badge bg-success">Terkonfirmasi</span>
                                                    @elseif($booking->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($booking->status === 'cancelled')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
                                                <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Statistics Panel -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0">Statistik Penerbangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="stats-item mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Pemesanan:</span>
                                <strong>{{ $flight->bookings->count() }}</strong>
                            </div>
                        </div>

                        <div class="stats-item mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Penumpang:</span>
                                <strong>{{ $flight->bookings->sum('passengers_count') }}</strong>
                            </div>
                        </div>

                        <div class="stats-item mb-3">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Kapasitas Pesawat:</span>
                                <strong>{{ $flight->aircraft->capacity ?? 'N/A' }}</strong>
                            </div>
                        </div>

                        @php
                            $totalPassengers = $flight->bookings->sum('passengers_count');
                            $capacity = $flight->aircraft->capacity ?? 0;
                            $occupancy = $capacity > 0 ? ($totalPassengers / $capacity) * 100 : 0;
                        @endphp

                        <div class="stats-item mb-3">
                            <span class="text-muted">Okupansi:</span>
                            <div class="progress mt-2">
                                <div class="progress-bar" role="progressbar" style="width: {{ $occupancy }}%">
                                    {{ round($occupancy, 1) }}%
                                </div>
                            </div>
                        </div>

                        <div class="stats-item">
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Total Pendapatan:</span>
                                <strong class="text-success">
                                    Rp
                                    {{ number_format($flight->bookings->where('status', 'confirmed')->sum('total_price'), 0, ',', '.') }}
                                </strong>
                            </div>
                        </div>
                    </div>
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

        .price-info {
            text-align: center;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }

        .stats-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .stats-item:last-child {
            border-bottom: none;
        }
    </style>
@endsection
