@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Detail Pemesanan</h4>
                        <p class="text-muted">Informasi lengkap pemesanan {{ $booking->booking_code }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bx bx-printer me-2"></i>Cetak
                        </button>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Booking Status Card -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $booking->booking_code }}</h5>
                                        <p class="text-muted mb-0">Dibuat {{ $booking->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div>
                                        @if($booking->status === 'pending')
                                            <span class="badge bg-warning fs-6">Menunggu Konfirmasi</span>
                                        @elseif($booking->status === 'confirmed')
                                            <span class="badge bg-success fs-6">Dikonfirmasi</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge bg-danger fs-6">Dibatalkan</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-1">Total Pembayaran</h6>
                                <h4 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Flight Information -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Penerbangan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex align-items-center mb-3">
                                            @if($booking->flight->airline->logo)
                                                <img src="{{ Storage::url($booking->flight->airline->logo) }}"
                                                    alt="{{ $booking->flight->airline->name }}" class="rounded me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover;">
                                            @endif
                                            <div>
                                                <h6 class="fw-bold mb-1">{{ $booking->flight->airline->name }}</h6>
                                                <p class="text-muted mb-0">{{ $booking->flight->flight_number }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1"><strong>Pesawat:</strong>
                                            {{ $booking->flight->aircraft->aircraft_code }}</p>
                                        <p class="mb-0"><strong>Model:</strong> {{ $booking->flight->aircraft->model }}</p>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="text-center">
                                            <h6 class="fw-bold">{{ $booking->flight->departureAirport->code }}</h6>
                                            <p class="text-muted small mb-1">{{ $booking->flight->departureAirport->name }}
                                            </p>
                                            <p class="text-muted small">{{ $booking->flight->departureAirport->city }}</p>
                                            <div class="mt-2">
                                                <h5 class="fw-bold">
                                                    {{ \Carbon\Carbon::parse($booking->flight->departure_time)->format('H:i') }}
                                                </h5>
                                                <p class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($booking->flight->departure_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <div class="position-relative" style="margin-top: 60px;">
                                            <i class="bx bx-trip fs-3 text-primary"></i>
                                            <p class="text-muted small mt-2">{{ $booking->flight->duration ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="text-center">
                                            <h6 class="fw-bold">{{ $booking->flight->arrivalAirport->code }}</h6>
                                            <p class="text-muted small mb-1">{{ $booking->flight->arrivalAirport->name }}
                                            </p>
                                            <p class="text-muted small">{{ $booking->flight->arrivalAirport->city }}</p>
                                            <div class="mt-2">
                                                <h5 class="fw-bold">
                                                    {{ \Carbon\Carbon::parse($booking->flight->arrival_time)->format('H:i') }}
                                                </h5>
                                                <p class="text-muted small">
                                                    {{ \Carbon\Carbon::parse($booking->flight->departure_date)->format('d M Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Passengers Information -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Daftar Penumpang ({{ $booking->passengers->count() }})</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama</th>
                                                <th>Tipe</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Tanggal Lahir</th>
                                                <th>Kewarganegaraan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($booking->passengers as $passenger)
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <span class="fw-semibold">{{ $passenger->first_name }}
                                                                {{ $passenger->last_name }}</span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="badge bg-{{ $passenger->passenger_type === 'adult' ? 'primary' : ($passenger->passenger_type === 'child' ? 'warning' : 'info') }}">
                                                            {{ ucfirst($passenger->passenger_type) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $passenger->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d M Y') }}
                                                    </td>
                                                    <td>{{ $passenger->nationality }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer & Payment Information -->
                    <div class="col-md-4">
                        <!-- Customer Info -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pemesan</h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="small text-muted">Nama</label>
                                    <p class="fw-semibold mb-1">{{ $booking->user->name }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Email</label>
                                    <p class="fw-semibold mb-1">{{ $booking->user->email }}</p>
                                </div>
                                <div class="mb-3">
                                    <label class="small text-muted">Nomor Telepon</label>
                                    <p class="fw-semibold mb-1">{{ $booking->contact_phone ?? 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                @if($booking->payments && $booking->payments->count() > 0)
                                    @foreach($booking->payments as $payment)
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    <p class="fw-semibold mb-1">{{ $payment->payment_code }}</p>
                                                    <small class="text-muted">{{ $payment->payment_method }}</small>
                                                </div>
                                                <div>
                                                    @if($payment->status === 'pending')
                                                        <span class="badge bg-warning">Pending</span>
                                                    @elseif($payment->status === 'completed')
                                                        <span class="badge bg-success">Lunas</span>
                                                    @elseif($payment->status === 'failed')
                                                        <span class="badge bg-danger">Gagal</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <p class="fw-bold text-success mb-1">
                                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                                </p>
                                                @if($payment->paid_at)
                                                    <small class="text-muted">
                                                        Dibayar {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                                                    </small>
                                                @endif
                                            </div>
                                        </div>
                                        @if(!$loop->last)
                                            <hr>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="text-center text-muted py-3">
                                        <i class="bx bx-wallet fs-1 mb-2"></i>
                                        <p class="mb-0">Belum ada pembayaran</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Actions -->
                        @if($booking->status === 'pending')
                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="confirmed">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bx bx-check me-2"></i>Konfirmasi Pemesanan
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.bookings.update', $booking) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pemesanan ini?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="cancelled">
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bx bx-x me-2"></i>Batalkan Pemesanan
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection