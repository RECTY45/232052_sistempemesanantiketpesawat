@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold py-3 mb-2">Manajemen Penerbangan</h4>
            <p class="text-muted">Kelola jadwal dan rute penerbangan</p>
        </div>
        <a href="{{ route('admin.flights.create') }}" class="btn btn-primary">
            <i class="bx bx-plus me-2"></i>Tambah Penerbangan
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter Card -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.flights.index') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label">Nomor Penerbangan</label>
                        <input type="text" name="flight_number" class="form-control" 
                               value="{{ request('flight_number') }}" placeholder="Cari nomor penerbangan...">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Maskapai</label>
                        <select name="airline_id" class="form-select">
                            <option value="">Semua</option>
                            @foreach($airlines as $airline)
                                <option value="{{ $airline->id }}" 
                                        {{ request('airline_id') == $airline->id ? 'selected' : '' }}>
                                    {{ $airline->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                            <option value="boarding" {{ request('status') == 'boarding' ? 'selected' : '' }}>Boarding</option>
                            <option value="departed" {{ request('status') == 'departed' ? 'selected' : '' }}>Berangkat</option>
                            <option value="arrived" {{ request('status') == 'arrived' ? 'selected' : '' }}>Tiba</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tanggal</label>
                        <input type="date" name="date" class="form-control" 
                               value="{{ request('date') }}">
                    </div>
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-search me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-secondary">
                                Reset
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Flights Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Penerbangan</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Penerbangan</th>
                            <th>Rute</th>
                            <th>Jadwal</th>
                            <th>Pesawat</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($flights as $index => $flight)
                        <tr>
                            <td>{{ $flights->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    @if($flight->airline->logo)
                                        <img src="{{ Storage::url($flight->airline->logo) }}" 
                                             alt="{{ $flight->airline->name }}" 
                                             class="rounded me-2" 
                                             style="width: 30px; height: 30px; object-fit: cover;">
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $flight->flight_number }}</div>
                                        <small class="text-muted">{{ $flight->airline->name }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ $flight->departureAirport->code }}</span>
                                    <i class="bx bx-right-arrow-alt mx-1 text-muted"></i>
                                    <span class="fw-semibold">{{ $flight->arrivalAirport->code }}</span>
                                </div>
                                <small class="text-muted d-block">
                                    {{ $flight->departureAirport->city }} → {{ $flight->arrivalAirport->city }}
                                </small>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ $flight->departure_time->format('d M Y') }}</span>
                                </div>
                                <small class="text-muted">
                                    {{ $flight->departure_time->format('H:i') }} - 
                                    {{ $flight->arrival_time->format('H:i') }}
                                </small>
                            </td>
                            <td>
                                <div>
                                    <span class="fw-semibold">{{ $flight->aircraft->registration }}</span>
                                </div>
                                <small class="text-muted">{{ $flight->aircraft->model }}</small>
                            </td>
                            <td>
                                <div class="text-primary fw-semibold">
                                    Rp {{ number_format($flight->economy_price, 0, ',', '.') }}
                                </div>
                                @php
                                    $totalSeats = $flight->available_economy_seats + $flight->available_business_seats + $flight->available_first_class_seats;
                                @endphp
                                <small class="text-muted">{{ $totalSeats }} kursi</small>
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
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-horizontal-rounded"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.flights.show', $flight) }}">
                                                <i class="bx bx-show me-2"></i>Detail
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.flights.edit', $flight) }}">
                                                <i class="bx bx-edit me-2"></i>Edit
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('admin.flights.destroy', $flight) }}" method="POST" 
                                                  onsubmit="return confirm('Yakin ingin menghapus penerbangan ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bx bx-trash me-2"></i>Hapus
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <div class="d-flex flex-column align-items-center">
                                    <i class="bx bx-trip fs-1 text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data penerbangan</p>
                                    <a href="{{ route('admin.flights.create') }}" class="btn btn-primary btn-sm">
                                        Tambah Penerbangan Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($flights->hasPages())
        <div class="card-footer">
            {{ $flights->appends(request()->query())->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
