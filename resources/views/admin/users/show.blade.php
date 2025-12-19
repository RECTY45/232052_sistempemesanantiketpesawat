@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-1">
                    <span class="text-muted fw-light">Master Data /</span> Detail Pengguna
                </h4>
                <p class="text-muted">Informasi lengkap akun pengguna</p>
            </div>
            <div>
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary me-2"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Kembali</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="mb-1">{{ $user->name }} <small class="text-muted">({{ $user->roles }})</small></h5>
                        <p class="text-muted">{{ $user->email }}</p>
                        <table class="table table-borderless mt-3">
                            <tr>
                                <td class="text-muted">Telepon:</td>
                                <td>{{ $user->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Status Email:</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Verified</span>
                                    @else
                                        <span class="badge bg-warning">Unverified</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-muted">Terdaftar:</td>
                                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Statistik Booking</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <h4 class="mb-1">{{ $bookingStats['total'] ?? 0 }}</h4>
                                <small class="text-muted">Total</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-1">{{ $bookingStats['confirmed'] ?? 0 }}</h4>
                                <small class="text-muted">Terkonfirmasi</small>
                            </div>
                            <div class="col-4">
                                <h4 class="mb-1">{{ $bookingStats['pending'] ?? 0 }}</h4>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Bookings</h5>
                    </div>
                    <div class="card-body">
                        @if($recentBookings && $recentBookings->count() > 0)
                            <ul class="list-unstyled mb-0">
                                @foreach($recentBookings as $booking)
                                    <li class="mb-2">
                                        <div><strong>{{ $booking->flight->code ?? '—' }}</strong></div>
                                        <small class="text-muted">{{ $booking->created_at->format('d M Y') }} — {{ ucfirst($booking->status) }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">Belum ada booking terbaru.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
