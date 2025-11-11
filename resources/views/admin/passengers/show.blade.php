@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Detail Penumpang</h4>
                        <p class="text-muted">Informasi lengkap penumpang {{ $passenger->first_name }}
                            {{ $passenger->last_name }}</p>
                    </div>
                    <a href="{{ route('admin.passengers.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-2"></i>Kembali
                    </a>
                </div>

                <!-- Passenger Details Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Personal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Nama Lengkap:</td>
                                        <td>{{ $passenger->title }} {{ $passenger->first_name }} {{ $passenger->last_name }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis Kelamin:</td>
                                        <td>{{ $passenger->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Tanggal Lahir:</td>
                                        <td>{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d M Y') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Usia:</td>
                                        <td>{{ \Carbon\Carbon::parse($passenger->date_of_birth)->age }} tahun</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Tipe Penumpang:</td>
                                        <td>
                                            @if($passenger->passenger_type === 'adult')
                                                <span class="badge bg-primary">Dewasa</span>
                                            @elseif($passenger->passenger_type === 'child')
                                                <span class="badge bg-warning">Anak</span>
                                            @elseif($passenger->passenger_type === 'infant')
                                                <span class="badge bg-success">Bayi</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kewarganegaraan:</td>
                                        <td>{{ $passenger->nationality }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Dibuat:</td>
                                        <td>{{ $passenger->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Diupdate:</td>
                                        <td>{{ $passenger->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Booking Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pemesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted">Kode Pemesanan</label>
                                    <p class="fw-bold text-primary mb-1">{{ $passenger->booking->booking_code }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Status Pemesanan</label>
                                    <div>
                                        @if($passenger->booking->status === 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($passenger->booking->status === 'confirmed')
                                            <span class="badge bg-success">Dikonfirmasi</span>
                                        @elseif($passenger->booking->status === 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Total Penumpang</label>
                                    <p class="fw-semibold mb-1">{{ $passenger->booking->passengers->count() }} orang</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted">Total Pembayaran</label>
                                    <p class="fw-bold text-success mb-1">
                                        Rp {{ number_format($passenger->booking->total_amount, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Tanggal Pemesanan</label>
                                    <p class="fw-semibold mb-1">{{ $passenger->booking->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('admin.bookings.show', $passenger->booking) }}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bx bx-show me-1"></i>Lihat Detail Pemesanan
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flight Information -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Penerbangan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="d-flex align-items-center mb-3">
                                    @if($passenger->booking->flight->airline->logo)
                                        <img src="{{ Storage::url($passenger->booking->flight->airline->logo) }}"
                                            alt="{{ $passenger->booking->flight->airline->name }}" class="rounded me-3"
                                            style="width: 50px; height: 50px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <h6 class="fw-bold mb-1">{{ $passenger->booking->flight->airline->name }}</h6>
                                        <p class="text-muted mb-0">{{ $passenger->booking->flight->flight_number }}</p>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted">Pesawat</label>
                                    <p class="fw-semibold mb-1">
                                        {{ $passenger->booking->flight->aircraft->aircraft_code }}
                                        ({{ $passenger->booking->flight->aircraft->model }})
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="small text-muted">Rute Penerbangan</label>
                                    <p class="fw-semibold mb-1">
                                        {{ $passenger->booking->flight->departureAirport->code }} →
                                        {{ $passenger->booking->flight->arrivalAirport->code }}
                                    </p>
                                    <small class="text-muted">
                                        {{ $passenger->booking->flight->departureAirport->city }} →
                                        {{ $passenger->booking->flight->arrivalAirport->city }}
                                    </small>
                                </div>

                                <div class="mb-3">
                                    <label class="small text-muted">Jadwal</label>
                                    <p class="fw-semibold mb-1">
                                        {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_date)->format('d M Y') }}
                                    </p>
                                    <small class="text-muted">
                                        {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_time)->format('H:i') }}
                                        -
                                        {{ \Carbon\Carbon::parse($passenger->booking->flight->arrival_time)->format('H:i') }}
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Flight Route Visual -->
                        <hr>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="text-center">
                                    <h6 class="fw-bold">{{ $passenger->booking->flight->departureAirport->code }}</h6>
                                    <p class="text-muted small mb-1">
                                        {{ $passenger->booking->flight->departureAirport->name }}</p>
                                    <p class="text-muted small">{{ $passenger->booking->flight->departureAirport->city }}
                                    </p>
                                    <div class="mt-2">
                                        <h5 class="fw-bold">
                                            {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_time)->format('H:i') }}
                                        </h5>
                                        <p class="text-muted small">
                                            {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 text-center">
                                <div class="position-relative" style="margin-top: 60px;">
                                    <i class="bx bx-trip fs-3 text-primary"></i>
                                    <p class="text-muted small mt-2">{{ $passenger->booking->flight->duration ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="text-center">
                                    <h6 class="fw-bold">{{ $passenger->booking->flight->arrivalAirport->code }}</h6>
                                    <p class="text-muted small mb-1">{{ $passenger->booking->flight->arrivalAirport->name }}
                                    </p>
                                    <p class="text-muted small">{{ $passenger->booking->flight->arrivalAirport->city }}</p>
                                    <div class="mt-2">
                                        <h5 class="fw-bold">
                                            {{ \Carbon\Carbon::parse($passenger->booking->flight->arrival_time)->format('H:i') }}
                                        </h5>
                                        <p class="text-muted small">
                                            {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_date)->format('d M Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection