@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Manajemen Pemesanan</h4>
                <p class="text-muted">Kelola semua pemesanan tiket penerbangan</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn btn-outline-primary" onclick="window.print()">
                    <i class="bx bx-printer me-2"></i>Cetak Laporan
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-shopping-bag text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">{{ $stats['total_bookings'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Pemesanan</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-check-circle text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold text-success">{{ $stats['confirmed_bookings'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Dikonfirmasi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-time text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold text-warning">{{ $stats['pending_bookings'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Menunggu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-x-circle text-danger fs-1 mb-3"></i>
                        <h3 class="fw-bold text-danger">{{ $stats['cancelled_bookings'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Dibatalkan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bookings.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Kode Pemesanan</label>
                            <input type="text" name="booking_code" class="form-control"
                                value="{{ request('booking_code') }}" placeholder="Cari kode pemesanan...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>
                                    Dikonfirmasi</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Pemesanan</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Booking</th>
                                <th>Penumpang</th>
                                <th>Penerbangan</th>
                                <th>Tanggal Pesan</th>
                                <th>Total Harga</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr>
                                    <td>
                                        <div>
                                            <span class="fw-bold text-primary">{{ $booking->booking_code }}</span>
                                            <small class="text-muted d-block">{{ $booking->passengers_count }} penumpang</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $booking->user->name }}</span>
                                            <small class="text-muted d-block">{{ $booking->user->email }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $booking->flight->flight_number }}</span>
                                            <small class="text-muted d-block">
                                                {{ $booking->flight->departureAirport->code }} →
                                                {{ $booking->flight->arrivalAirport->code }}
                                            </small>
                                            <small class="text-muted d-block">
                                                {{ \Carbon\Carbon::parse($booking->flight->departure_date)->format('d M Y') }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $booking->created_at->format('d M Y') }}</span>
                                            <small class="text-muted d-block">{{ $booking->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        @if($booking->status === 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="badge bg-success">Dikonfirmasi</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-danger">Dibatalkan</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
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
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.bookings.show', $booking) }}">
                                                        <i class="bx bx-show me-2"></i>Detail
                                                    </a>
                                                </li>
                                                @if($booking->status === 'pending')
                                                    <li>
                                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="confirmed">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="bx bx-check me-2"></i>Konfirmasi
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="cancelled">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bx bx-x me-2"></i>Batalkan
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-shopping-bag fs-1 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data pemesanan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($bookings->hasPages())
                <div class="card-footer">
                    {{ $bookings->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection