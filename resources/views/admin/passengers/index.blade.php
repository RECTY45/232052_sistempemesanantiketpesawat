@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Manajemen Penumpang</h4>
                <p class="text-muted">Data semua penumpang yang telah melakukan perjalanan</p>
            </div>
            <button class="btn btn-outline-primary" onclick="window.print()">
                <i class="bx bx-printer me-2"></i>Cetak Laporan
            </button>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-user text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">{{ $stats['total_passengers'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Penumpang</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-male text-info fs-1 mb-3"></i>
                        <h3 class="fw-bold text-info">{{ $stats['adult_passengers'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Dewasa</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-child text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold text-warning">{{ $stats['child_passengers'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Anak-anak</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-baby-carriage text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold text-success">{{ $stats['infant_passengers'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Bayi</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.passengers.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Nama Penumpang</label>
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Cari nama penumpang...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tipe</label>
                            <select name="passenger_type" class="form-select">
                                <option value="">Semua Tipe</option>
                                <option value="adult" {{ request('passenger_type') == 'adult' ? 'selected' : '' }}>Dewasa
                                </option>
                                <option value="child" {{ request('passenger_type') == 'child' ? 'selected' : '' }}>Anak
                                </option>
                                <option value="infant" {{ request('passenger_type') == 'infant' ? 'selected' : '' }}>Bayi
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="gender" class="form-select">
                                <option value="">Semua</option>
                                <option value="M" {{ request('gender') == 'M' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="F" {{ request('gender') == 'F' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Kewarganegaraan</label>
                            <input type="text" name="nationality" class="form-control" value="{{ request('nationality') }}"
                                placeholder="Negara...">
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.passengers.index') }}" class="btn btn-outline-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Passengers Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Penumpang</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Penumpang</th>
                                <th>Tipe</th>
                                <th>Detail</th>
                                <th>Kewarganegaraan</th>
                                <th>Pemesanan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($passengers as $index => $passenger)
                                <tr>
                                    <td>{{ $passengers->firstItem() + $index }}</td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $passenger->first_name }}
                                                {{ $passenger->last_name }}</span>
                                            @if($passenger->title)
                                                <small class="text-muted d-block">{{ $passenger->title }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($passenger->passenger_type === 'adult')
                                            <span class="badge bg-primary">Dewasa</span>
                                        @elseif($passenger->passenger_type === 'child')
                                            <span class="badge bg-warning">Anak</span>
                                        @elseif($passenger->passenger_type === 'infant')
                                            <span class="badge bg-success">Bayi</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <small class="text-muted">Jenis Kelamin:</small>
                                            <span
                                                class="fw-semibold d-block">{{ $passenger->gender === 'M' ? 'Laki-laki' : 'Perempuan' }}</span>
                                            <small class="text-muted">Lahir:</small>
                                            <span
                                                class="fw-semibold d-block">{{ \Carbon\Carbon::parse($passenger->date_of_birth)->format('d M Y') }}</span>
                                            <small class="text-muted">Usia:</small>
                                            <span
                                                class="fw-semibold d-block">{{ \Carbon\Carbon::parse($passenger->date_of_birth)->age }}
                                                tahun</span>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="fw-semibold">{{ $passenger->nationality }}</span>
                                    </td>
                                    <td>
                                        <div>
                                            <span
                                                class="fw-semibold text-primary">{{ $passenger->booking->booking_code }}</span>
                                            <small
                                                class="text-muted d-block">{{ $passenger->booking->flight->flight_number }}</small>
                                            <small class="text-muted d-block">
                                                {{ $passenger->booking->flight->departureAirport->code }} →
                                                {{ $passenger->booking->flight->arrivalAirport->code }}
                                            </small>
                                            <small class="text-muted d-block">
                                                {{ \Carbon\Carbon::parse($passenger->booking->flight->departure_date)->format('d M Y') }}
                                            </small>
                                        </div>
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
                                                        href="{{ route('admin.passengers.show', $passenger) }}">
                                                        <i class="bx bx-show me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.bookings.show', $passenger->booking) }}">
                                                        <i class="bx bx-shopping-bag me-2"></i>Lihat Pemesanan
                                                    </a>
                                                </li>
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form action="{{ route('admin.passengers.destroy', $passenger) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Yakin ingin menghapus data penumpang ini?')">
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
                                            <i class="bx bx-user fs-1 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data penumpang</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($passengers->hasPages())
                <div class="card-footer">
                    {{ $passengers->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection