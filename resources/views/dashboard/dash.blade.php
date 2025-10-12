@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card border-0 shadow-sm">
        <div class="d-flex align-items-end row">
            <div class="col-sm-7">
                <div class="card-body">
                    <h5 class="card-title text-primary h3">
                        Selamat Datang, {{ auth()->user()->name }}! 🎉
                    </h5>
                    <p class="mb-4 h5 text-muted">
                        Senang sekali melihat Anda kembali di <strong>Travelo</strong> —  
                        aplikasi pemesanan tiket pesawat yang cepat, mudah, dan terpercaya.  
                        Nikmati pengalaman memesan tiket dengan nyaman dan hemat waktu!
                    </p>
                    <a href="{{ route('dash.index') }}" class="btn btn-primary mt-2">
                        ✈️ Pesan Tiket Sekarang
                    </a>
                </div>
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <div class="card-body pb-0 px-0 px-md-4">
                    <img src="{{ asset('img/illustrations/man-with-laptop-light.png') }}"
                        height="160" alt="Welcome to Travelo"
                        data-app-dark-img="illustrations/man-with-laptop-dark.png"
                        data-app-light-img="illustrations/man-with-laptop-light.png" />
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
