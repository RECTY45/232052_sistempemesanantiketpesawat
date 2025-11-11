@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Detail Pesawat</h4>
                        <p class="text-muted">Informasi lengkap pesawat {{ $aircraft->aircraft_code }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.aircraft.edit', $aircraft) }}" class="btn btn-primary">
                            <i class="bx bx-edit me-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.aircraft.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Aircraft Details Card -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Pesawat</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Kode Pesawat:</td>
                                        <td>
                                            <span class="badge bg-primary fs-6">{{ $aircraft->aircraft_code }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Model:</td>
                                        <td>{{ $aircraft->model }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Pabrik:</td>
                                        <td>{{ $aircraft->manufacturer }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Kapasitas:</td>
                                        <td>
                                            <span class="fw-semibold text-primary">{{ $aircraft->capacity }}</span>
                                            penumpang
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-semibold" style="width: 150px;">Maskapai:</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($aircraft->airline->logo)
                                                    <img src="{{ Storage::url($aircraft->airline->logo) }}"
                                                        alt="{{ $aircraft->airline->name }}" class="rounded me-2"
                                                        style="width: 40px; height: 40px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $aircraft->airline->name }}</div>
                                                    <small class="text-muted">{{ $aircraft->airline->code }}</small>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Status:</td>
                                        <td>
                                            @if($aircraft->status === 'active')
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Dibuat:</td>
                                        <td>{{ $aircraft->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-semibold">Diupdate:</td>
                                        <td>{{ $aircraft->updated_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        @if($aircraft->description)
                            <div class="mt-3">
                                <h6 class="fw-semibold">Deskripsi:</h6>
                                <p class="text-muted">{{ $aircraft->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Flights History -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Riwayat Penerbangan</h5>
                    </div>
                    <div class="card-body">
                        @if($aircraft->flights && $aircraft->flights->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Nomor Penerbangan</th>
                                            <th>Rute</th>
                                            <th>Tanggal</th>
                                            <th>Waktu</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($aircraft->flights->take(10) as $flight)
                                            <tr>
                                                <td>
                                                    <span class="fw-semibold">{{ $flight->flight_number }}</span>
                                                </td>
                                                <td>
                                                    {{ $flight->departureAirport->code }}
                                                    <i class="bx bx-right-arrow-alt mx-1"></i>
                                                    {{ $flight->arrivalAirport->code }}
                                                </td>
                                                <td>{{ \Carbon\Carbon::parse($flight->departure_date)->format('d M Y') }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($flight->departure_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($flight->arrival_time)->format('H:i') }}
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
                            @if($aircraft->flights->count() > 10)
                                <div class="text-center mt-3">
                                    <small class="text-muted">
                                        Menampilkan 10 penerbangan terakhir dari total {{ $aircraft->flights->count() }} penerbangan
                                    </small>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-plane fs-1 text-muted mb-3"></i>
                                <p class="text-muted">Belum ada riwayat penerbangan untuk pesawat ini</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection