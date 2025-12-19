@extends('layouts.main')

@section('content')
    <div class="container-fluid dashboard-page pb-4">
        <style>
            /* Palet warna dan tipografi dengan kontras tinggi */
            :root {
                --ink: #0f172a;
                --muted: #475569;
                --soft-bg: #f8fafc;
            }

            .dashboard-page {
                background: #f4f7fb;
            }

            .dashboard-hero {
                background: linear-gradient(135deg, #0ea5e9, #2563eb);
                color: #fff;
                border-radius: 18px;
                padding: 28px;
                position: relative;
                overflow: hidden;
                box-shadow: 0 12px 32px rgba(14, 165, 233, 0.28);
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.22);
            }

            .dashboard-hero::after {
                content: "";
                position: absolute;
                right: -40px;
                top: -40px;
                width: 180px;
                height: 180px;
                background: rgba(255, 255, 255, 0.12);
                border-radius: 50%;
            }

            .dashboard-hero::before {
                content: "";
                position: absolute;
                left: -20px;
                bottom: -20px;
                width: 120px;
                height: 120px;
                background: rgba(255, 255, 255, 0.08);
                border-radius: 50%;
            }

            .text-white-75 {
                color: rgba(255, 255, 255, 0.75);
            }

            .stat-card {
                border: 0;
                border-radius: 16px;
                box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08);
                color: var(--ink);
            }

            .icon-circle {
                width: 48px;
                height: 48px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .bg-soft-primary {
                background: #e8f2ff;
                color: #0d6efd;
            }

            .bg-soft-warning {
                background: #fff3cd;
                color: #d48806;
            }

            .bg-soft-success {
                background: #e8fff3;
                color: #138f5b;
            }

            .table td,
            .table th {
                vertical-align: middle;
                color: var(--ink);
            }

            .quick-card {
                border-radius: 14px;
            }

            .support-box {
                background: linear-gradient(135deg, #0ea5e9, #2563eb);
                color: #fff;
                border-radius: 14px;
                padding: 18px;
                box-shadow: 0 8px 24px rgba(14, 165, 233, 0.35);
                text-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
            }

            .card-header h5,
            .card-header h6,
            .card-body p {
                color: var(--ink);
            }

            .text-muted,
            small {
                color: var(--muted) !important;
            }

            .hero-meta {
                color: rgba(255, 255, 255, 0.9);
                letter-spacing: 0.2px;
            }

            .table thead {
                background: var(--soft-bg);
            }

            .btn-outline-info {
                color: #0ea5e9;
                border-color: #0ea5e9;
            }

            .btn-outline-info:hover {
                background: #0ea5e9;
                color: #fff;
            }
        </style>

        <div class="dashboard-hero mb-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start">
                <div class="pr-md-4">
                    <p class="text-white-75 mb-1 small text-uppercase">Dasbor Pelanggan</p>
                    <h2 class="mb-2 text-white">Halo, {{ auth()->user()->name }}!</h2>
                    <p class="mb-3 text-white-75">Pantau status pemesanan, lanjutkan pencarian, atau lakukan check-in dari
                        satu tempat.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('customer.search-flights') }}" class="btn btn-light btn-sm mr-2 mb-2">
                            <i class="fas fa-search mr-1"></i> Cari Penerbangan
                        </a>
                        <a href="{{ route('customer.my-bookings') }}" class="btn btn-outline-light btn-sm mb-2">
                            <i class="fas fa-list mr-1"></i> Pemesanan Saya
                        </a>
                    </div>
                </div>
                <div class="text-right mt-3 mt-md-0 hero-meta">
                    <div class="badge badge-pill badge-light px-3 py-2 mb-2 bg-soft-success"
                        style="color:#0b63ce; background:rgba(255,255,255,0.18); border:1px solid rgba(255,255,255,0.25);">
                        <i class="fas fa-check-circle mr-1"></i> Dikonfirmasi: {{ $confirmedBookings }}
                    </div>
                    <p class="small mb-0">Ringkasan per {{ now()->format('d M Y') }}</p>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-circle bg-soft-primary mr-3">
                            <i class="fas fa-plane text-primary"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Total Pemesanan</p>
                            <h4 class="mb-0">{{ $totalBookings }}</h4>
                        </div>
                        <span class="ml-auto badge badge-primary badge-pill">Semua</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-circle bg-soft-warning mr-3">
                            <i class="fas fa-clock text-warning"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Pemesanan Menunggu</p>
                            <h4 class="mb-0">{{ $pendingBookings }}</h4>
                        </div>
                        <span class="ml-auto badge badge-warning badge-pill text-white">Menunggu</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-3">
                <div class="card stat-card">
                    <div class="card-body d-flex align-items-center">
                        <div class="icon-circle bg-soft-success mr-3">
                            <i class="fas fa-check text-success"></i>
                        </div>
                        <div>
                            <p class="text-muted mb-1">Pemesanan Dikonfirmasi</p>
                            <h4 class="mb-0">{{ $confirmedBookings }}</h4>
                        </div>
                        <span class="ml-auto badge badge-success badge-pill">Aktif</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="card shadow-sm border-0 rounded-lg h-100">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0">Pemesanan Terbaru</h5>
                            <small class="text-muted">Lihat 10 pemesanan terakhir Anda</small>
                        </div>
                        <a href="{{ route('customer.my-bookings') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
                    </div>
                    <div class="card-body">
                        @if($recentBookings->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Kode</th>
                                            <th>Penerbangan</th>
                                            <th>Rute</th>
                                            <th>Jadwal</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentBookings as $booking)
                                            <tr>
                                                <td><strong>{{ $booking->booking_code }}</strong></td>
                                                <td>{{ $booking->flight->airline->name }} {{ $booking->flight->flight_number }}</td>
                                                <td>{{ $booking->flight->departureAirport->city }} →
                                                    {{ $booking->flight->arrivalAirport->city }}
                                                </td>
                                                <td>{{ $booking->flight->departure_time->format('M d, Y H:i') }}</td>
                                                <td>
                                                    @if($booking->status === 'confirmed')
                                                        <span class="badge badge-success badge-pill"
                                                            style="color: green">Confirmed</span>
                                                    @elseif($booking->status === 'pending')
                                                        <span class="badge badge-warning badge-pill"
                                                            style="color: orange">Pending</span>
                                                    @else
                                                        <span class="badge badge-secondary badge-pill"
                                                            style="color: cyan">{{ ucfirst($booking->status) }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('customer.booking-details', $booking->id) }}"
                                                        class="btn btn-sm btn-outline-info">
                                                        <i class="fas fa-eye"></i> Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-plane fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum ada pemesanan</h5>
                                <p class="text-muted">Mulai perjalanan Anda dengan mencari penerbangan pertama.</p>
                                <a href="{{ route('customer.search-flights') }}" class="btn btn-primary">
                                    <i class="fas fa-search mr-2"></i> Cari Penerbangan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="card quick-card shadow-sm border-0 mb-3">
                    <div class="card-header bg-white border-0">
                        <h6 class="mb-0">Aksi Cepat</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-2">
                            <a href="{{ route('customer.search-flights') }}" class="btn btn-primary btn-block">
                                <i class="fas fa-search mr-2"></i> Cari Penerbangan
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="{{ route('customer.my-bookings') }}" class="btn btn-outline-primary btn-block">
                                <i class="fas fa-list mr-2"></i> Pemesanan Saya
                            </a>
                        </div>
                        <div class="mb-2">
                            <button class="btn btn-secondary btn-block" data-toggle="modal" data-target="#checkInModal">
                                <i class="fas fa-check-circle mr-2"></i> Check-in Online
                            </button>
                        </div>
                        <div>
                            <a href="https://wa.me/6281340413101?text=Halo%20Admin,%20saya%20butuh%20bantuan%20untuk%20pemesanan%20saya."
                                target="_blank" class="btn btn-success btn-block">
                                <i class="fas fa-headset mr-2"></i> Dukungan Cepat
                            </a>
                        </div>
                    </div>
                </div>

                <div class="support-box">
                    <div class="d-flex align-items-center mb-2">
                        <span class="icon-circle bg-white text-primary mr-2" style="width: 40px; height: 40px;">
                            <i class="fas fa-headset"></i>
                        </span>
                        <div>
                            <strong>Dukungan 24/7</strong>
                            <p class="mb-0 text-white-75 small">Hubungi tim kami kapan saja</p>
                        </div>
                    </div>
                    <p class="mb-1"><i class="fas fa-phone mr-2"></i> +62-800-1234-5678</p>
                    <p class="mb-3"><i class="fas fa-envelope mr-2"></i> support@airline.com</p>
                    <div class="d-flex flex-wrap">
                        <a href="https://wa.me/6281340413101?text=Halo%20Admin,%20saya%20butuh%20bantuan%20untuk%20pemesanan%20saya."
                            target="_blank" class="btn btn-light btn-sm mr-2 mb-2">
                            <i class="fab fa-whatsapp mr-1"></i> WhatsApp
                        </a>
                        <button class="btn btn-outline-light btn-sm mb-2" data-toggle="modal" data-target="#supportModal">
                            <i class="fas fa-info-circle mr-1"></i> Detail Dukungan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Check-in Modal -->
    <div class="modal fade" id="checkInModal" tabindex="-1" role="dialog" aria-labelledby="checkInModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="checkInModalLabel">Online Check-in</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="bookingCode">Booking Code</label>
                            <input type="text" class="form-control" id="bookingCode" placeholder="Enter your booking code">
                        </div>
                        <div class="form-group">
                            <label for="lastName">Last Name</label>
                            <input type="text" class="form-control" id="lastName" placeholder="Enter passenger last name">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Check-in</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Support Modal -->
    <div class="modal fade" id="supportModal" tabindex="-1" role="dialog" aria-labelledby="supportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="supportModalLabel">Customer Support</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h6>Contact Information:</h6>
                    <p><strong>Phone:</strong> +62-800-1234-5678</p>
                    <p><strong>Email:</strong> support@airline.com</p>
                    <p><strong>Hours:</strong> 24/7</p>

                    <h6 class="mt-4">Quick Help:</h6>
                    <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action">Change Flight</a>
                        <a href="#" class="list-group-item list-group-item-action">Cancel Booking</a>
                        <a href="#" class="list-group-item list-group-item-action">Refund Request</a>
                        <a href="#" class="list-group-item list-group-item-action">Special Assistance</a>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection