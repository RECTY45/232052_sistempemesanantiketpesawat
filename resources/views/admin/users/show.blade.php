@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Detail Pengguna</h4>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.users.index') }}">Pengguna</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $user->name }}</li>
                    </ol>
                </nav>
            </div>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-2">
                    <i class="bx bx-edit me-1"></i>Edit
                </a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-1"></i>Kembali
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row">
            <!-- User Info -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="avatar-wrapper mb-3">
                            <div class="avatar avatar-xl">
                                <span class="avatar-initial rounded-circle bg-label-primary fs-2">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </span>
                            </div>
                        </div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-3">{{ $user->email }}</p>

                        @if($user->roles === 'admin')
                            <span class="badge bg-danger fs-6">Admin</span>
                        @else
                            <span class="badge bg-primary fs-6">Customer</span>
                        @endif

                        @if($user->id === auth()->id())
                            <span class="badge bg-warning fs-6 ms-1">You</span>
                        @endif
                    </div>
                </div>

                <!-- Account Details -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h5 class="mb-0">Informasi Akun</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-borderless">
                            <tr>
                                <td class="text-muted">User ID:</td>
                                <td class="fw-semibold">#{{ $user->id }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Email:</td>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Telepon:</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Role:</td>
                                <td>{{ ucfirst($user->roles) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status Email:</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                        <small class="d-block text-muted">
                                            {{ $user->email_verified_at->format('d M Y') }}
                                        </small>
                                    @else
                                        <span class="badge bg-warning">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Terdaftar:</td>
                                <td>
                                    <span class="fw-semibold">{{ $user->created_at->format('d M Y') }}</span>
                                    <small class="d-block text-muted">{{ $user->created_at->format('H:i') }}</small>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Update Terakhir:</td>
                                <td>
                                    <span>{{ $user->updated_at->format('d M Y') }}</span>
                                    <small class="d-block text-muted">{{ $user->updated_at->format('H:i') }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Booking History & Statistics -->
            <div class="col-md-8">
                @if($user->roles === 'customer')
                    <!-- Booking Statistics -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bx bx-calendar-check text-primary mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="mb-1">{{ $bookingStats['total'] }}</h4>
                                    <span class="text-muted">Total Booking</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bx bx-check-circle text-success mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="mb-1">{{ $bookingStats['confirmed'] }}</h4>
                                    <span class="text-muted">Terkonfirmasi</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bx bx-time text-warning mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="mb-1">{{ $bookingStats['pending'] }}</h4>
                                    <span class="text-muted">Pending</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class="bx bx-x-circle text-danger mb-2" style="font-size: 2rem;"></i>
                                    <h4 class="mb-1">{{ $bookingStats['cancelled'] }}</h4>
                                    <span class="text-muted">Dibatalkan</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Bookings -->
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Booking Terbaru</h5>
                            <a href="{{ route('admin.bookings.index', ['user_id' => $user->id]) }}"
                                class="btn btn-sm btn-outline-primary">
                                Lihat Semua
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recentBookings->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Kode Booking</th>
                                                <th>Rute</th>
                                                <th>Tanggal</th>
                                                <th>Total</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentBookings as $booking)
                                                <tr>
                                                    <td>
                                                        <span class="fw-semibold">{{ $booking->booking_code }}</span>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="fw-semibold">{{ $booking->flight->departureAirport->code }}</span>
                                                            <i class="bx bx-right-arrow-alt mx-1"></i>
                                                            <span class="fw-semibold">{{ $booking->flight->arrivalAirport->code }}</span>
                                                        </div>
                                                        <small class="text-muted">{{ $booking->flight->airline->name }}</small>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span>{{ $booking->flight->departure_time->format('d M Y') }}</span>
                                                            <small
                                                                class="d-block text-muted">{{ $booking->flight->departure_time->format('H:i') }}</small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="fw-semibold">Rp {{ number_format($booking->total_price) }}</span>
                                                    </td>
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
                                                    <td>
                                                        <a href="{{ route('admin.bookings.show', $booking) }}"
                                                            class="btn btn-sm btn-outline-primary">
                                                            <i class="bx bx-show"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="bx bx-calendar-x fs-1 text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada riwayat booking</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Admin Activity Info -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Admin</h5>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="bx bx-info-circle me-2"></i>
                                <strong>Admin Account</strong><br>
                                User ini memiliki akses penuh ke panel administrasi dan dapat mengelola seluruh sistem pemesanan
                                tiket.
                            </div>

                            <h6>Hak Akses Admin:</h6>
                            <ul class="list-unstyled">
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Maskapai</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Bandara</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Pesawat</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Kelas Penerbangan</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Jadwal Penerbangan</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Booking Customer</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Penumpang</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola Pembayaran</li>
                                <li><i class="bx bx-check text-success me-2"></i>Mengelola User & Admin</li>
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
