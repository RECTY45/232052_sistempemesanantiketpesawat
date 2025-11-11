@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Welcome Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
            <div class="row align-items-center">
                <div class="col-md-8 px-4 py-4">
                    @if (auth()->user()->roles == 'customer')
                        <h2 class="fw-bold text-primary mb-2">Selamat Datang, {{ auth()->user()->name }}! 🎉</h2>
                        <p class="text-muted mb-4 fs-5">
                            Senang melihat Anda kembali di <strong>Travelo</strong> — aplikasi pemesanan tiket pesawat
                            yang cepat, mudah, dan terpercaya. Nikmati pengalaman terbaik memesan tiket!
                        </p>
                        <a href="{{ route('dash.index') }}" class="btn btn-lg btn-primary shadow-sm rounded-pill px-4">
                            ✈️ Pesan Tiket Sekarang
                        </a>
                    @elseif (auth()->user()->roles == 'admin')
                        <h2 class="fw-bold text-primary mb-2">Halo, {{ auth()->user()->name }} 👋</h2>
                        <p class="text-muted mb-4 fs-5">
                            Selamat datang kembali di <strong>Travelo Dashboard</strong>.
                            Kelola data penerbangan, pantau transaksi, dan pastikan semuanya berjalan lancar.
                        </p>
                    @endif
                </div>
                <div class="col-md-4 text-center p-4">
                    <img src="{{ asset('img/illustrations/man-with-laptop-light.png') }}" class="img-fluid"
                        alt="Dashboard Illustration" style="max-height: 200px;">
                </div>
            </div>
        </div>

        @if (auth()->user()->roles == 'admin')
            <!-- Admin Dashboard Stats -->
            <div class="row g-4 mb-4">
                <!-- Total Users -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Pengguna</p>
                                    <h2 class="fw-bold text-primary mb-0">{{ $stats['users'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-user fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#007bff,#66b2ff);"></div>
                    </div>
                </div>

                <!-- Total Airlines -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Maskapai</p>
                                    <h2 class="fw-bold text-success mb-0">{{ $stats['airlines'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-plane-alt fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#198754,#69e089);"></div>
                    </div>
                </div>

                <!-- Total Airports -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Bandara</p>
                                    <h2 class="fw-bold text-info mb-0">{{ $stats['airports'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-buildings fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#0dcaf0,#66e6ff);"></div>
                    </div>
                </div>

                <!-- Total Flights -->
                <div class="col-lg-3 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Penerbangan</p>
                                    <h2 class="fw-bold text-warning mb-0">{{ $stats['flights'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-trip fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#ffc107,#ffed4a);"></div>
                    </div>
                </div>
            </div>

            <!-- Second Row Stats -->
            <div class="row g-4 mb-4">
                <!-- Total Bookings -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Pemesanan</p>
                                    <h2 class="fw-bold text-purple mb-0">{{ $stats['bookings'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-purple bg-opacity-10 text-purple rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-shopping-bag fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#6f42c1,#b794f6);"></div>
                    </div>
                </div>

                <!-- Successful Payments -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Pembayaran Sukses</p>
                                    <h2 class="fw-bold text-success mb-0">{{ $stats['payments_success'] ?? 0 }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-check-circle fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#198754,#69e089);"></div>
                    </div>
                </div>

                <!-- Total Revenue -->
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-muted mb-1 fw-semibold">Total Pendapatan</p>
                                    <h2 class="fw-bold text-success mb-0">Rp
                                        {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center"
                                    style="width:50px;height:50px;">
                                    <i class="bx bx-wallet fs-4"></i>
                                </div>
                            </div>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100"
                            style="height:4px; background:linear-gradient(90deg,#198754,#69e089);"></div>
                    </div>
                </div>
            </div>

        @endif

        <!-- Quick Actions for Admin -->
        @if (auth()->user()->roles == 'admin')
            <div class="row g-4">
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="mb-0">Quick Actions</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-6">
                                    <a href="{{ route('admin.airlines.index') }}" class="btn btn-outline-primary w-100 py-3">
                                        <i class="bx bx-plane-alt d-block mb-2 fs-4"></i>
                                        <small>Kelola Maskapai</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.airports.index') }}" class="btn btn-outline-info w-100 py-3">
                                        <i class="bx bx-buildings d-block mb-2 fs-4"></i>
                                        <small>Kelola Bandara</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-warning w-100 py-3">
                                        <i class="bx bx-trip d-block mb-2 fs-4"></i>
                                        <small>Kelola Penerbangan</small>
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-success w-100 py-3">
                                        <i class="bx bx-shopping-bag d-block mb-2 fs-4"></i>
                                        <small>Kelola Pemesanan</small>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity placeholder -->
                <div class="col-lg-6">
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-header border-0 bg-transparent">
                            <h5 class="mb-0">Aktivitas Terbaru</h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center text-muted py-4">
                                <i class="bx bx-time fs-1 mb-3"></i>
                                <p>Belum ada aktivitas terbaru</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>
        .hover-shadow:hover {
            transform: translateY(-5px);
            transition: all 0.25s ease-in-out;
            box-shadow: 0 0.75rem 1.25rem rgba(0, 0, 0, 0.08) !important;
        }

        .text-purple {
            color: #6f42c1 !important;
        }

        .bg-purple {
            background-color: #6f42c1 !important;
        }
    </style>

@endsection