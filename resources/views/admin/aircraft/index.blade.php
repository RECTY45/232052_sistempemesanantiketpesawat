@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Manajemen Pesawat</h4>
                <p class="text-muted">Kelola data pesawat untuk setiap maskapai</p>
            </div>
            <a href="{{ route('admin.aircraft.create') }}" class="btn btn-primary">
                <i class="bx bx-plus me-2"></i>Tambah Pesawat
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Aircraft Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pesawat</h5>
                <div class="d-flex gap-2">
                    <input type="text" class="form-control" placeholder="Cari pesawat..." style="width: 250px;">
                    <select class="form-select" style="width: 200px;">
                        <option value="">Semua Maskapai</option>
                        @foreach($airlines as $airline)
                            <option value="{{ $airline->id }}">{{ $airline->name }}</option>
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
                                <th>Kode Pesawat</th>
                                <th>Model</th>
                                <th>Maskapai</th>
                                <th>Kapasitas</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($aircraft as $index => $item)
                                <tr>
                                    <td>{{ $aircraft->firstItem() + $index }}</td>
                                    <td>
                                        <span class="badge bg-primary">{{ $item->registration }}</span>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <span class="fw-semibold">{{ $item->model }}</span>
                                            <small class="text-muted">{{ $item->manufacturer }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($item->airline->logo)
                                                <img src="{{ Storage::url($item->airline->logo) }}" alt="{{ $item->airline->name }}"
                                                    class="rounded me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                            @endif
                                            <span>{{ $item->airline->name }}</span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <span class="fw-semibold">{{ $item->total_seats }}</span>
                                            <small class="text-muted d-block">penumpang</small>
                                        </div>
                                    </td>
                                    <td>
                                        @if($item->is_active)
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
                                                    <a class="dropdown-item" href="{{ route('admin.aircraft.show', $item) }}">
                                                        <i class="bx bx-show me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item" href="{{ route('admin.aircraft.edit', $item) }}">
                                                        <i class="bx bx-edit me-2"></i>Edit
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.aircraft.destroy', $item) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus pesawat ini?')">
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
                                            <i class="bx bx-plane fs-1 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data pesawat</p>
                                            <a href="{{ route('admin.aircraft.create') }}" class="btn btn-primary btn-sm">
                                                Tambah Pesawat Pertama
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($aircraft->hasPages())
                <div class="card-footer">
                    {{ $aircraft->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection