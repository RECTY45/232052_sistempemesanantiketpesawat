@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Manajemen Bandara</h4>
                <p class="text-muted">Kelola data bandara di seluruh Indonesia</p>
            </div>
            <a href="{{ route('admin.airports.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Tambah Bandara
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Airports Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Bandara</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Cari bandara..." style="width: 250px;">
                    <select class="form-select" style="width: 200px;">
                        <option value="">Semua Kota</option>
                        @foreach($airports->unique('city') as $airport)
                            <option value="{{ $airport->city }}">{{ $airport->city }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Kode IATA</th>
                                <th>Nama Bandara</th>
                                <th>Lokasi</th>
                                <th>Zona Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($airports as $index => $airport)
                                <tr>
                                    <td>{{ $airports->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-primary fs-6">{{ $airport->code }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $airport->name }}</span>
                                            @if($airport->international)
                                                <small class="text-primary">🌍 Internasional</small>
                                            @else
                                                <small class="text-muted">🏠 Domestik</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $airport->city }}</span>
                                            <small class="text-muted d-block">{{ $airport->country }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $airport->timezone }}</span>
                                    </td>
                                    <td>
                                        @if($airport->is_active)
                                            <span class="badge bg-success">Aktif</span>
                                        @else
                                            <span class="badge bg-danger">Tidak Aktif</span>
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
                                                        href="{{ route('admin.airports.show', $airport) }}">
                                                        <i class="bx bx-show me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.airports.edit', $airport) }}">
                                                        <i class="bx bx-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.airports.destroy', $airport) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus bandara ini?')">
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
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-buildings fs-1 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data bandara</p>
                                            <a href="{{ route('admin.airports.create') }}" class="btn btn-primary btn-sm">
                                                Tambah Bandara Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($airports->hasPages())
                <div class="card-footer">
                    {{ $airports->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection