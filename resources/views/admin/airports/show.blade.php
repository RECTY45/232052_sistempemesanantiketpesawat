@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Detail Bandara</h4>
                        <p class="text-muted">Informasi lengkap bandara {{ $airport->name }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.airports.edit', $airport) }}" class="btn btn-primary">
                            <i class="bx bx-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.airports.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Airport Details Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Bandara</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Kode IATA:</td>
                                        <td>
                                            <span class="badge bg-primary fs-6">{{ $airport->code }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Nama:</td>
                                        <td>{{ $airport->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kota:</td>
                                        <td>{{ $airport->city }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Negara:</td>
                                        <td>{{ $airport->country }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Jenis:</td>
                                        <td>
                                            @if($airport->international)
                                                <span class="badge bg-success">🌍 Internasional</span>
                                            @else
                                                <span class="badge bg-info">🏠 Domestik</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Zona Waktu:</td>
                                        <td>
                                            <span class="badge bg-info">{{ $airport->timezone }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status:</td>
                                        <td>
                                            @if($airport->status === 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($airport->latitude && $airport->longitude)
                                        <tr>
                                            <td class="fw-semibold">Koordinat:</td>
                                            <td>
                                                <small class="text-muted">Lat:</small> {{ $airport->latitude }}<br>
                                                <small class="text-muted">Lng:</small> {{ $airport->longitude }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td class="fw-semibold">Dibuat:</td>
                                        <td>{{ $airport->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Diupdate:</td>
                                        <td>{{ $airport->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flights Statistics -->
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bx bx-plane-take-off text-primary fs-1 mb-3"></i>
                                <h3 class="fw-bold">
                                    {{ $airport->departureFlights ? $airport->departureFlights->count() : 0 }}</h3>
                                <p class="text-muted mb-0">Penerbangan Keberangkatan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bx bx-plane-land text-success fs-1 mb-3"></i>
                                <h3 class="fw-bold">{{ $airport->arrivalFlights ? $airport->arrivalFlights->count() : 0 }}
                                </h3>
                                <p class="text-muted mb-0">Penerbangan Kedatangan</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="bx bx-trip text-info fs-1 mb-3"></i>
                                <h3 class="fw-bold">
                                    {{ ($airport->departureFlights ? $airport->departureFlights->count() : 0) + ($airport->arrivalFlights ? $airport->arrivalFlights->count() : 0) }}
                                </h3>
                                <p class="text-muted mb-0">Total Penerbangan</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Flights -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Penerbangan Terbaru</h5>
                    </div>
                    <div class="card-body">
                        @if($airport->departureFlights && $airport->departureFlights->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nomor Penerbangan</th>
                                            <th>Tujuan</th>
                                            <th>Maskapai</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($airport->departureFlights->take(10) as $flight)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold">{{ $flight->flight_number }}</span>
                                                </td>
                                                <td>
                                                    <div>
                                                        <span class="fw-semibold">{{ $flight->arrivalAirport->code }}</span>
                                                        <small
                                                            class="text-muted d-block">{{ $flight->arrivalAirport->city }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($flight->airline->logo)
                                                            <img src="{{ Storage::url($flight->airline->logo) }}"
                                                                alt="{{ $flight->airline->name }}" class="rounded me-2"
                                                                style="width: 25px; height: 25px; object-fit: cover;">
                                                        @endif
                                                        <span class="small">{{ $flight->airline->name }}</span>
                                                    </div>
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($flight->departure_date)->format('d M Y') }}</td>
                                                <td>
                                                    <div>
                                                        <span
                                                            class="fw-semibold">{{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }}</span>
                                                        <small
                                                            class="text-muted d-block">{{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($flight->status === 'scheduled')
                                                        <span class="badge bg-primary">Terjadwal</span>
                                                    @elseif($flight->status === 'boarding')
                                                        <span class="badge bg-warning">Boarding</span>
                                                    @elseif($flight->status === 'departed')
                                                        <span class="badge bg-info">Berangkat</span>
                                                    @elseif($flight->status === 'arrived')
                                                        <span class="badge bg-success">Tiba</span>
                                                    @elseif($flight->status === 'cancelled')
                                                        <span class="badge bg-danger">Dibatalkan</span>
                                                    @else
                                                        <span class="badge bg-secondary">{{ ucfirst($flight->status) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @if($airport->departureFlights->count() > 10)
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Menampilkan 10 penerbangan terakhir dari total {{ $airport->departureFlights->count() }}
                                        penerbangan keberangkatan
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-plane fs-1 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada penerbangan dari bandara ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection