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
                        Kelola data pengguna, pantau transaksi, dan pastikan semuanya berjalan lancar.
                    </p>
                @endif
            </div>
            <div class="col-md-4 text-center p-4">
                <img src="{{ asset('img/illustrations/man-with-laptop-light.png') }}" 
                     class="img-fluid" alt="Dashboard Illustration" 
                     style="max-height: 200px;">
            </div>
        </div>
    </div>

    @if (auth()->user()->roles == 'admin')
    <!-- Dashboard Stats Cards -->
    <div class="row g-4">
        <!-- Total Users -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold">Total Pengguna</p>
                            <h2 class="fw-bold text-primary mb-0">{{ $users }}</h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;">
                            <i class="bi bx bx-user fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" 
                     style="height:4px; background:linear-gradient(90deg,#007bff,#66b2ff);"></div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold">Total Pemesanan</p>
                            <h2 class="fw-bold text-success mb-0">13</h2>
                        </div>
                        <div class="bg-success bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;">
                            <i class="bx bx-cart fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" 
                     style="height:4px; background:linear-gradient(90deg,#198754,#69e089);"></div>
            </div>
        </div>

        <!-- Total Tickets Sold -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 hover-shadow position-relative overflow-hidden">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-semibold">Tiket Terjual</p>
                            <h2 class="fw-bold text-info mb-0">15</h2>
                        </div>
                        <div class="bg-info bg-opacity-10 text-white rounded-circle d-flex align-items-center justify-content-center"
                             style="width:50px;height:50px;">
                            <i class="bx bx-wallet-alt fs-4"></i>
                        </div>
                    </div>
                </div>
                <div class="position-absolute bottom-0 start-0 w-100" 
                     style="height:4px; background:linear-gradient(90deg,#0dcaf0,#66e6ff);"></div>
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
</style>

@endsection
