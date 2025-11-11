@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-1">
                    <span class="text-muted fw-light">Master Data /</span> Kelola Maskapai
                </h4>
                <p class="text-muted">Kelola data maskapai penerbangan yang tersedia</p>
            </div>
            <a href="{{ route('admin.airlines.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-1"></i> Tambah Maskapai
            </a>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bx bx-x-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Airlines Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Maskapai</h5>
                <small class="text-muted">Total: {{ $airlines->count() }} maskapai</small>
            </div>
            <div class="card-body">
                @if($airlines->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Logo</th>
                                    <th>Kode</th>
                                    <th>Nama Maskapai</th>
                                    <th>Negara</th>
                                    <th>Kontak</th>
                                    <th>Status</th>
                                    <th>Pesawat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airlines as $airline)
                                    <tr>
                                        <td>
                                            @if($airline->logo)
                                                <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}"
                                                    class="rounded" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                    style="width: 40px; height: 40px;">
                                                    <i class="bx bx-plane text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-primary">{{ $airline->code }}</span>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $airline->name }}</strong>
                                                @if($airline->description)
                                                    <br><small class="text-muted">{{ Str::limit($airline->description, 50) }}</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td>{{ $airline->country }}</td>
                                        <td>
                                            @if($airline->phone)
                                                <div><i class="bx bx-phone text-muted"></i> {{ $airline->phone }}</div>
                                            @endif
                                            @if($airline->website)
                                                <div>
                                                    <a href="{{ $airline->website }}" target="_blank" class="text-decoration-none">
                                                        <i class="bx bx-globe text-muted"></i> Website
                                                    </a>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($airline->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Nonaktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $airline->aircraft->count() }}</span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                    data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('admin.airlines.show', $airline) }}">
                                                        <i class="bx bx-show me-1"></i> Detail
                                                    </a>
                                                    <a class="dropdown-item" href="{{ route('admin.airlines.edit', $airline) }}">
                                                        <i class="bx bx-edit-alt me-1"></i> Edit
                                                    </a>
                                                    <div class="dropdown-divider"></div>
                                                    <form action="{{ route('admin.airlines.destroy', $airline) }}" method="POST"
                                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus maskapai ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="bx bx-trash me-1"></i> Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-5">
                        <img src="{{ asset('img/illustrations/empty-state.svg') }}" alt="No data" class="mb-3"
                            style="width: 200px;">
                        <h5 class="text-muted">Belum ada data maskapai</h5>
                        <p class="text-muted">Silakan tambahkan maskapai untuk memulai</p>
                        <a href="{{ route('admin.airlines.create') }}" class="btn btn-primary">
                            <i class="bx bx-plus me-1"></i> Tambah Maskapai Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection