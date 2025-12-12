@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-10 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Detail Pembayaran</h4>
                        <p class="text-muted">Informasi lengkap transaksi {{ $payment->payment_code }}</p>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-outline-primary" onclick="window.print()">
                            <i class="bx bx-printer me-2"></i>Cetak
                        </button>
                        <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">
                            <i class="bx bx-arrow-back me-2"></i>Kembali
                        </a>
                    </div>
                </div>

                <!-- Payment Status Card -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="fw-bold mb-1">{{ $payment->payment_code }}</h5>
                                        <p class="text-muted mb-0">Dibuat {{ $payment->created_at->diffForHumans() }}</p>
                                        @if($payment->external_payment_id)
                                            <small class="text-muted">External ID: {{ $payment->external_payment_id }}</small>
                                        @endif
                                    </div>
                                    <div>
                                        @if($payment->status === 'pending')
                                            <span class="badge bg-warning fs-6">Menunggu Pembayaran</span>
                                        @elseif($payment->status === 'success')
                                            <span class="badge bg-success fs-6">Pembayaran Selesai</span>
                                        @elseif($payment->status === 'failed')
                                            <span class="badge bg-danger fs-6">Pembayaran Gagal</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <h6 class="text-muted mb-1">Total Pembayaran</h6>
                                <h4 class="fw-bold text-success mb-0">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </h4>
                                @if($payment->admin_fee > 0)
                                    <small class="text-muted">+Adm: Rp
                                        {{ number_format($payment->admin_fee, 0, ',', '.') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Payment Information -->
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pembayaran</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-semibold" style="width: 150px;">Metode:</td>
                                                <td>
                                                    @if($payment->payment_method === 'credit_card')
                                                        <span class="badge bg-primary">
                                                            <i class="bx bx-credit-card me-1"></i>Kartu Kredit
                                                        </span>
                                                    @elseif($payment->payment_method === 'bank_transfer')
                                                        <span class="badge bg-info">
                                                            <i class="bx bx-transfer me-1"></i>Transfer Bank
                                                        </span>
                                                    @elseif($payment->payment_method === 'e_wallet')
                                                        <span class="badge bg-warning">
                                                            <i class="bx bx-wallet me-1"></i>E-Wallet
                                                        </span>
                                                    @elseif($payment->payment_method === 'cash')
                                                        <span class="badge bg-success">
                                                            <i class="bx bx-money me-1"></i>Cash
                                                        </span>
                                                    @else
                                                        <span
                                                            class="badge bg-secondary">{{ ucfirst($payment->payment_method) }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="fw-semibold">Jumlah:</td>
                                                <td class="text-success fw-bold">Rp
                                                    {{ number_format($payment->amount, 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            @if($payment->admin_fee > 0)
                                                <tr>
                                                    <td class="fw-semibold">Biaya Admin:</td>
                                                    <td>Rp {{ number_format($payment->admin_fee, 0, ',', '.') }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="fw-semibold">Dibuat:</td>
                                                <td>{{ $payment->created_at->format('d M Y, H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td class="fw-semibold" style="width: 150px;">Status:</td>
                                                <td>
                                                    @if($payment->status === 'pending')
                                                        <span class="badge bg-warning">Menunggu</span>
                                                    @elseif($payment->status === 'success')
                                                        <span class="badge bg-success">Selesai</span>
                                                    @elseif($payment->status === 'failed')
                                                        <span class="badge bg-danger">Gagal</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($payment->paid_at)
                                                <tr>
                                                    <td class="fw-semibold">Dibayar:</td>
                                                    <td class="text-success fw-semibold">
                                                        {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($payment->expired_at)
                                                <tr>
                                                    <td class="fw-semibold">Kadaluarsa:</td>
                                                    <td>{{ \Carbon\Carbon::parse($payment->expired_at)->format('d M Y, H:i') }}
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="fw-semibold">Diupdate:</td>
                                                <td>{{ $payment->updated_at->format('d M Y, H:i') }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                                @if($payment->notes)
                                    <hr>
                                    <div>
                                        <h6 class="fw-semibold">Catatan:</h6>
                                        <p class="text-muted">{{ $payment->notes }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Booking Information -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pemesanan</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="small text-muted">Kode Pemesanan</label>
                                            <p class="fw-bold text-primary mb-1">{{ $payment->booking->booking_code }}</p>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small text-muted">Penerbangan</label>
                                            <p class="fw-semibold mb-1">{{ $payment->booking->flight->flight_number }}</p>
                                            <small class="text-muted">
                                                {{ $payment->booking->flight->departureAirport->code }} →
                                                {{ $payment->booking->flight->arrivalAirport->code }}
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="small text-muted">Pemesan</label>
                                            <p class="fw-semibold mb-1">{{ $payment->booking->user->name }}</p>
                                            <small class="text-muted">{{ $payment->booking->user->email }}</small>
                                        </div>
                                        <div class="mb-3">
                                            <label class="small text-muted">Jumlah Penumpang</label>
                                            <p class="fw-semibold mb-1">{{ $payment->booking->passengers->count() }} orang
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="text-center">
                                    <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="btn btn-primary">
                                        <i class="bx bx-show me-1"></i>Lihat Detail Pemesanan
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Proof Section -->
                        @if($payment->payment_proof)
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="mb-0">Bukti Pembayaran</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @php
                                                $fileExtension = pathinfo($payment->payment_proof, PATHINFO_EXTENSION);
                                                $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']);
                                            @endphp

                                            @if($isImage)
                                                <div class="text-center mb-3">
                                                    <img src="{{ asset('storage/' . $payment->payment_proof) }}"
                                                        alt="Bukti Pembayaran" class="img-fluid rounded shadow"
                                                        style="max-height: 400px; max-width: 100%;"
                                                        onclick="showImageModal(this.src)">
                                                </div>
                                                <div class="text-center">
                                                    <button class="btn btn-primary btn-sm"
                                                        onclick="showImageModal('{{ asset('storage/' . $payment->payment_proof) }}')">
                                                        <i class="bx bx-zoom-in me-1"></i>Perbesar Gambar
                                                    </button>
                                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}"
                                                        class="btn btn-outline-secondary btn-sm" download>
                                                        <i class="bx bx-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            @else
                                                <div class="text-center">
                                                    <div class="mb-3">
                                                        <i class="bx bx-file-blank" style="font-size: 48px; color: #6c757d;"></i>
                                                    </div>
                                                    <p class="text-muted">File bukti pembayaran ({{ strtoupper($fileExtension) }})
                                                    </p>
                                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}"
                                                        class="btn btn-primary" target="_blank">
                                                        <i class="bx bx-show me-1"></i>Lihat File
                                                    </a>
                                                    <a href="{{ asset('storage/' . $payment->payment_proof) }}"
                                                        class="btn btn-outline-secondary" download>
                                                        <i class="bx bx-download me-1"></i>Download
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Actions & Timeline -->
                    <div class="col-md-4">
                        <!-- Actions -->
                        @if($payment->status === 'pending')
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Aksi</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-grid gap-2">
                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="success">
                                            <input type="hidden" name="paid_at" value="{{ now() }}">
                                            <button type="submit" class="btn btn-success w-100">
                                                <i class="bx bx-check me-2"></i>Konfirmasi Pembayaran
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.payments.update', $payment) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menandai sebagai gagal?')">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="failed">
                                            <button type="submit" class="btn btn-danger w-100">
                                                <i class="bx bx-x me-2"></i>Gagal Bayar
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Payment Timeline -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Timeline</h5>
                            </div>
                            <div class="card-body">
                                <div class="timeline">
                                    <div class="timeline-item">
                                        <div class="timeline-marker bg-primary"></div>
                                        <div class="timeline-content">
                                            <h6 class="fw-semibold">Pembayaran Dibuat</h6>
                                            <p class="text-muted mb-0">{{ $payment->created_at->format('d M Y, H:i') }}</p>
                                            <small class="text-muted">{{ $payment->created_at->diffForHumans() }}</small>
                                        </div>
                                    </div>

                                    @if($payment->paid_at)
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-success"></div>
                                            <div class="timeline-content">
                                                <h6 class="fw-semibold">Pembayaran Selesai</h6>
                                                <p class="text-muted mb-0">
                                                    {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
                                                </p>
                                                <small
                                                    class="text-muted">{{ \Carbon\Carbon::parse($payment->paid_at)->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endif

                                    @if($payment->status === 'failed')
                                        <div class="timeline-item">
                                            <div class="timeline-marker bg-danger"></div>
                                            <div class="timeline-content">
                                                <h6 class="fw-semibold">Pembayaran Gagal</h6>
                                                <p class="text-muted mb-0">{{ $payment->updated_at->format('d M Y, H:i') }}</p>
                                                <small class="text-muted">{{ $payment->updated_at->diffForHumans() }}</small>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .timeline {
            position: relative;
            padding-left: 30px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -25px;
            top: 20px;
            width: 2px;
            height: calc(100% + 5px);
            background: #e3e7f3;
        }

        .timeline-marker {
            position: absolute;
            left: -30px;
            top: 5px;
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .timeline-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #e3e7f3;
        }
    </style>

    <!-- Image Modal -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Bukti Pembayaran" class="img-fluid">
                </div>
                <div class="modal-footer">
                    <a id="downloadLink" href="" class="btn btn-primary" download>
                        <i class="bx bx-download me-1"></i>Download
                    </a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showImageModal(imageSrc) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('downloadLink').href = imageSrc;
            var imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }
    </script>

@endsection