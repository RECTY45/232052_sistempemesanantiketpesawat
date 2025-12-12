@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Booking Summary -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Ringkasan Pemesanan</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Informasi Penerbangan</h6>
                                <p class="mb-1"><strong>{{ $booking->flight->airline->name }}</strong></p>
                                <p class="mb-1">{{ $booking->flight->flight_number }}</p>
                                <p class="mb-1">{{ $booking->flight->departureAirport->city }} →
                                    {{ $booking->flight->arrivalAirport->city }}
                                </p>
                                <p class="mb-1">{{ $booking->flight->departure_time->format('M d, Y H:i') }}</p>
                                <p class="mb-0">Kelas {{ $booking->flight_class_name }}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Detail Pemesanan</h6>
                                <p class="mb-1"><strong>Kode Pemesanan:</strong> {{ $booking->booking_code }}</p>
                                <p class="mb-1"><strong>Penumpang:</strong> {{ $booking->passengers_count }}</p>
                                <p class="mb-1"><strong>Status:</strong> {{ ucfirst($booking->status) }}</p>
                                <h5 class="mt-3 text-primary"><strong>Total: Rp
                                        {{ number_format($booking->total_price, 0, ',', '.') }}</strong></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Passengers -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0">Daftar Penumpang</h6>
                    </div>
                    <div class="card-body">
                        @foreach($booking->passengers as $index => $passenger)
                            <div
                                class="d-flex justify-content-between align-items-center {{ $index < $booking->passengers->count() - 1 ? 'mb-2 pb-2 border-bottom' : '' }}">
                                <div>
                                    <strong>{{ $passenger->name }}</strong><br>
                                    <small class="text-muted">{{ $passenger->phone }}</small>
                                    @if($passenger->email)
                                        <br><small class="text-muted">{{ $passenger->email }}</small>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Payment Methods -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Choose Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('customer.process-payment', $booking->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <!-- Credit Card -->
                                <div class="col-md-4 mb-3">
                                    <div class="card payment-method">
                                        <div class="card-body text-center">
                                            <input type="radio" class="form-check-input" name="payment_method"
                                                value="credit_card" id="credit_card" required>
                                            <label for="credit_card" class="form-check-label w-100">
                                                <i class="fas fa-credit-card fa-2x text-primary mb-2 d-block"></i>
                                                <h6>Credit Card</h6>
                                                <small class="text-muted">Visa, MasterCard, etc.</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bank Transfer -->
                                <div class="col-md-4 mb-3">
                                    <div class="card payment-method">
                                        <div class="card-body text-center">
                                            <input type="radio" class="form-check-input" name="payment_method"
                                                value="bank_transfer" id="bank_transfer" required>
                                            <label for="bank_transfer" class="form-check-label w-100">
                                                <i class="fas fa-university fa-2x text-success mb-2 d-block"></i>
                                                <h6>Bank Transfer</h6>
                                                <small class="text-muted">All major banks</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-Wallet -->
                                <div class="col-md-4 mb-3">
                                    <div class="card payment-method">
                                        <div class="card-body text-center">
                                            <input type="radio" class="form-check-input" name="payment_method"
                                                value="e_wallet" id="e_wallet" required>
                                            <label for="e_wallet" class="form-check-label w-100">
                                                <i class="fas fa-mobile-alt fa-2x text-warning mb-2 d-block"></i>
                                                <h6>E-Wallet</h6>
                                                <small class="text-muted">GoPay, OVO, DANA</small>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Upload Payment Proof Section -->
                            <div class="card mt-4" id="upload_section" style="display: none;">
                                <div class="card-header">
                                    <h6 class="mb-0"><i class="fas fa-upload mr-2"></i>Upload Bukti Pembayaran</h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        Silakan upload bukti pembayaran Anda (screenshot, foto, atau scan) dalam format JPG,
                                        PNG, atau PDF. Maksimal ukuran file 5MB.
                                    </div>

                                    <div class="form-group">
                                        <label for="payment_proof" class="form-label"><strong>Pilih File Bukti
                                                Pembayaran</strong></label>
                                        <input type="file" class="form-control" id="payment_proof" name="payment_proof"
                                            accept=".jpg,.jpeg,.png,.pdf" required>
                                        <small class="form-text text-muted">
                                            Format yang didukung: JPG, PNG, PDF (Maksimal 5MB)
                                        </small>
                                        @error('payment_proof')
                                            <div class="text-danger mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Preview area for image -->
                                    <div id="image_preview" style="display: none;" class="mt-3">
                                        <label class="form-label"><strong>Preview:</strong></label>
                                        <div class="text-center">
                                            <img id="preview_img" src="" alt="Preview" class="img-fluid rounded"
                                                style="max-height: 300px;">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Payment Information -->
                            <div class="payment-info mt-4" style="display: none;">
                                <!-- Credit Card Info -->
                                <div id="credit_card_info" class="payment-detail" style="display: none;">
                                    <h6>Credit Card Information</h6>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i>
                                        You will be redirected to secure payment gateway to complete your transaction.
                                    </div>
                                </div>

                                <!-- Bank Transfer Info -->
                                <div id="bank_transfer_info" class="payment-detail" style="display: none;">
                                    <h6>Bank Transfer Information</h6>
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Please complete the payment within 24 hours to secure your booking.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>Bank BCA</strong><br>
                                            <span>Account: 1234567890</span><br>
                                            <span>Name: Travelo Airlines</span>
                                        </div>
                                        <div class="col-md-6">
                                            <strong>Bank Mandiri</strong><br>
                                            <span>Account: 0987654321</span><br>
                                            <span>Name: Travelo Airlines</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- E-Wallet Info -->
                                <div id="e_wallet_info" class="payment-detail" style="display: none;">
                                    <h6>E-Wallet Payment</h6>
                                    <div class="alert alert-success">
                                        <i class="fas fa-check-circle mr-2"></i>
                                        You will receive a notification on your phone to complete the payment.
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary btn-lg btn-block">
                                    <i class="fas fa-credit-card mr-2"></i> Pay Now - Rp
                                    {{ number_format($booking->total_price, 0, ',', '.') }}
                                </button>
                            </div>

                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-shield-alt mr-1"></i> Your payment is secured with SSL encryption
                                </small>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .payment-method {
            border: 2px solid #e0e0e0;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #007bff;
            box-shadow: 0 2px 8px rgba(0, 123, 255, 0.2);
        }

        .payment-method.selected {
            border-color: #007bff;
            background-color: #f8f9ff;
        }

        .form-check-input {
            position: absolute;
            opacity: 0;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
            const paymentInfo = document.querySelector('.payment-info');
            const uploadSection = document.getElementById('upload_section');
            const paymentProofInput = document.getElementById('payment_proof');
            const imagePreview = document.getElementById('image_preview');
            const previewImg = document.getElementById('preview_img');

            paymentMethods.forEach(method => {
                method.addEventListener('change', function () {
                    // Remove selected class from all cards
                    document.querySelectorAll('.payment-method').forEach(card => {
                        card.classList.remove('selected');
                    });

                    // Add selected class to current card
                    this.closest('.payment-method').classList.add('selected');

                    // Hide all payment details
                    document.querySelectorAll('.payment-detail').forEach(detail => {
                        detail.style.display = 'none';
                    });

                    // Show selected payment detail
                    const selectedDetail = document.getElementById(this.value + '_info');
                    if (selectedDetail) {
                        selectedDetail.style.display = 'block';
                        paymentInfo.style.display = 'block';
                    }

                    // Show upload section for all payment methods
                    uploadSection.style.display = 'block';
                });
            });

            // Handle file upload preview
            paymentProofInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const fileType = file.type;
                    const validImageTypes = ['image/jpeg', 'image/jpg', 'image/png'];

                    if (validImageTypes.includes(fileType)) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            previewImg.src = e.target.result;
                            imagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endsection