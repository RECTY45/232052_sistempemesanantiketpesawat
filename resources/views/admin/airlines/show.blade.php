@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-1">
                    <span class="text-muted fw-light">Master Data /</span> Detail Maskapai
                </h4>
                <p class="text-muted">Lihat informasi lengkap maskapai penerbangan</p>
            </div>
            <div>
                <a href="{{ route('admin.airlines.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bx bx-arrow-back me-1"></i> Kembali
                </a>
                <a href="{{ route('admin.airlines.edit', $airline) }}" class="btn btn-primary me-2">
                    <i class="bx bx-edit-alt me-1"></i> Edit
                </a>
                <form action="{{ route('admin.airlines.destroy', $airline) }}" method="POST" class="d-inline"
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus maskapai ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-trash me-1"></i> Hapus
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bx bx-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card mb-4">
            <div class="card-body d-flex gap-4">
                <div>
                    @if($airline->logo)
                        <img src="{{ asset('storage/' . $airline->logo) }}" alt="{{ $airline->name }}" class="rounded"
                             style="width:120px;height:120px;object-fit:cover;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="width:120px;height:120px;">
                            <i class="bx bx-plane text-muted fs-2"></i>
                        </div>
                    @endif
                </div>
                <div class="flex-grow-1">
                    <h3 class="mb-1">{{ $airline->name }} <small class="text-muted">({{ $airline->code }})</small></h3>
                    @if($airline->description)
                        <p class="text-muted mb-1">{{ $airline->description }}</p>
                    @endif
                    <div class="row">
                        <div class="col-md-4 text-muted">
                            <strong>Negara:</strong> {{ $airline->country ?? '-' }}
                        </div>
                        <div class="col-md-4 text-muted">
                            <strong>Kontak:</strong>
                            @if($airline->phone) {{ $airline->phone }} @else - @endif
                        </div>
                        <div class="col-md-4 text-muted">
                            <strong>Status:</strong>
                            @if($airline->is_active)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-secondary">Nonaktif</span>
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        @if($airline->website)
                            <a href="{{ $airline->website }}" target="_blank" class="text-decoration-none">
                                <i class="bx bx-globe me-1"></i> Kunjungi Website
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Daftar Pesawat</h5>
                <small class="text-muted">Total: {{ $airline->aircraft->count() }}</small>
            </div>
            <div class="card-body">
                @if($airline->aircraft->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama / Tipe</th>
                                    <th>Registrasi</th>
                                    <th>Kapasitas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($airline->aircraft as $aircraft)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $aircraft->name ?? ($aircraft->type ?? '-') }}</strong>
                                            @if($aircraft->description)
                                                <br><small class="text-muted">{{ Str::limit($aircraft->description, 60) }}</small>
                                            @endif
                                        </td>
                                        <td>{{ $aircraft->registration ?? '-' }}</td>
                                        <td>{{ $aircraft->capacity ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">Belum ada data pesawat untuk maskapai ini.</div>
                @endif
            </div>
        </div>

    </div>
@endsection
