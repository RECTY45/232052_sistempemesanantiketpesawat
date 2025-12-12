@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-2">Manajemen Pembayaran</h4>
                <p class="text-muted">Kelola semua transaksi pembayaran</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.payments.print') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                    class="btn btn-outline-primary" target="_blank">
                    <i class="bx bx-printer me-2"></i>Cetak Laporan
                </a>
                <a href="{{ route('admin.payments.export') }}{{ request()->getQueryString() ? '?' . request()->getQueryString() : '' }}"
                    class="btn btn-outline-success">
                    <i class="bx bx-download me-2"></i>Export Excel
                </a>
            </div>
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
                        <i class="bx bx-money text-primary fs-1 mb-3"></i>
                        <h3 class="fw-bold">{{ $stats['total_payments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Total Transaksi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-check-circle text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold text-success">{{ $stats['completed_payments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Berhasil</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-time text-warning fs-1 mb-3"></i>
                        <h3 class="fw-bold text-warning">{{ $stats['pending_payments'] ?? 0 }}</h3>
                        <p class="text-muted mb-0">Menunggu</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center">
                        <i class="bx bx-wallet text-success fs-1 mb-3"></i>
                        <h3 class="fw-bold text-success">Rp {{ number_format($stats['total_revenue'] ?? 0, 0, ',', '.') }}
                        </h3>
                        <p class="text-muted mb-0">Total Pendapatan</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.payments.index') }}">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label">Kode Pembayaran</label>
                            <input type="text" name="payment_code" class="form-control"
                                value="{{ request('payment_code') }}" placeholder="Cari kode pembayaran...">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Metode</label>
                            <select name="payment_method" class="form-select">
                                <option value="">Semua Metode</option>
                                <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Kartu Kredit</option>
                                <option value="bank_transfer" {{ request('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Transfer Bank</option>
                                <option value="e_wallet" {{ request('payment_method') == 'e_wallet' ? 'selected' : '' }}>
                                    E-Wallet</option>
                                <option value="cash" {{ request('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu
                                </option>
                                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Selesai
                                </option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Gagal</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tanggal Akhir</label>
                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-search"></i>
                            </button>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary ms-1">
                                <i class="bx bx-refresh"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Daftar Pembayaran</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Kode Pembayaran</th>
                                <th>Pemesanan</th>
                                <th>Jumlah</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>Bukti</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($payments as $payment)
                                <tr>
                                    <td>
                                        <div>
                                            <span class="fw-bold text-primary">{{ $payment->payment_code }}</span>
                                            @if($payment->external_payment_id)
                                                <small class="text-muted d-block">ID: {{ $payment->external_payment_id }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $payment->booking->booking_code }}</span>
                                            <small
                                                class="text-muted d-block">{{ $payment->booking->flight->flight_number }}</small>
                                            <small class="text-muted d-block">
                                                {{ $payment->booking->user->name }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                        </div>
                                        @if($payment->admin_fee > 0)
                                            <small class="text-muted">+Adm: Rp
                                                {{ number_format($payment->admin_fee, 0, ',', '.') }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($payment->method === 'credit_card')
                                            <span class="badge bg-primary">
                                                <i class="bx bx-credit-card me-1"></i>Kartu Kredit
                                            </span>
                                        @elseif($payment->method === 'bank_transfer')
                                            <span class="badge bg-info">
                                                <i class="bx bx-transfer me-1"></i>Transfer Bank
                                            </span>
                                        @elseif($payment->method === 'e_wallet')
                                            <span class="badge bg-warning">
                                                <i class="bx bx-wallet me-1"></i>E-Wallet
                                            </span>
                                        @elseif($payment->method === 'cash')
                                            <span class="badge bg-success">
                                                <i class="bx bx-money me-1"></i>Cash
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($payment->method) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold">{{ $payment->created_at->format('d M Y') }}</span>
                                            <small class="text-muted d-block">{{ $payment->created_at->format('H:i') }}</small>
                                            @if($payment->paid_at)
                                                <small class="text-success d-block">
                                                    Dibayar: {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($payment->status === 'pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                        @elseif($payment->status === 'success')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($payment->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if($payment->payment_proof)
                                            @php
                                                $fileExtension = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']);
                                            @endphp
                                            @if($isImage)
                                                <a href="{{ route('admin.payments.show', $payment) }}"
                                                    class="btn btn-sm btn-outline-success" title="Ada bukti pembayaran (Gambar)">
                                                    <i class="bx bx-image"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('admin.payments.show', $payment) }}"
                                                    class="btn btn-sm btn-outline-info"
                                                    title="Ada bukti pembayaran ({{ strtoupper($fileExtension) }})">
                                                    <i class="bx bx-file"></i>
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-muted" title="Belum ada bukti pembayaran">
                                                <i class="bx bx-x"></i>
                                            </span>
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
                                                        href="{{ route('admin.payments.show', $payment) }}">
                                                        <i class="bx bx-show me-2"></i>Detail
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item"
                                                        href="{{ route('admin.bookings.show', $payment->booking) }}">
                                                        <i class="bx bx-shopping-bag me-2"></i>Lihat Pemesanan
                                                    </a>
                                                </li>
                                                @if($payment->status === 'pending')
                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="success">
                                                            <input type="hidden" name="paid_at" value="{{ now() }}">
                                                            <button type="submit" class="dropdown-item text-success">
                                                                <i class="bx bx-check me-2"></i>Konfirmasi Bayar
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin menandai sebagai gagal?')">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="failed">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="bx bx-x me-2"></i>Gagal Bayar
                                                            </button>
                                                        </form>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <div class="d-flex flex-column align-items-center">
                                            <i class="bx bx-money fs-1 text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada data pembayaran</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($payments->hasPages())
                <div class="card-footer">
                    {{ $payments->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection