@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-1">
                    <span class="text-muted fw-light">Master Data / Maskapai /</span> Tambah Baru
                </h4>
                <p class="text-muted">Tambahkan maskapai penerbangan baru</p>
            </div>
            <a href="{{ route('admin.airlines.index') }}" class="btn btn-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        <!-- Form Card -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Informasi Maskapai</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.airlines.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Kode Maskapai <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                    name="code" value="{{ old('code') }}" placeholder="Contoh: GA, JT, ID" maxlength="10"
                                    style="text-transform: uppercase;" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kode IATA maskapai (maksimal 10 karakter)</small>
                            </div>

                            <div class="mb-3">
                                <label for="name" class="form-label">Nama Maskapai <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name') }}" placeholder="Contoh: Garuda Indonesia" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Negara <span class="text-danger">*</span></label>
                                <select class="form-select @error('country') is-invalid @enderror" id="country"
                                    name="country" required>
                                    <option value="">Pilih Negara</option>
                                    <option value="Indonesia" {{ old('country') == 'Indonesia' ? 'selected' : '' }}>Indonesia
                                    </option>
                                    <option value="Malaysia" {{ old('country') == 'Malaysia' ? 'selected' : '' }}>Malaysia
                                    </option>
                                    <option value="Singapore" {{ old('country') == 'Singapore' ? 'selected' : '' }}>Singapore
                                    </option>
                                    <option value="Thailand" {{ old('country') == 'Thailand' ? 'selected' : '' }}>Thailand
                                    </option>
                                    <option value="Philippines" {{ old('country') == 'Philippines' ? 'selected' : '' }}>
                                        Philippines</option>
                                    <option value="Vietnam" {{ old('country') == 'Vietnam' ? 'selected' : '' }}>Vietnam
                                    </option>
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone"
                                    name="phone" value="{{ old('phone') }}" placeholder="Contoh: +62-21-2351-9999">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="logo" class="form-label">Logo Maskapai</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" id="logo"
                                    name="logo" accept="image/jpeg,image/png,image/jpg,image/gif">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, JPEG, PNG, GIF. Maksimal 2MB</small>
                            </div>

                            <div class="mb-3">
                                <label for="website" class="form-label">Website</label>
                                <input type="url" class="form-control @error('website') is-invalid @enderror" id="website"
                                    name="website" value="{{ old('website') }}" placeholder="https://www.example.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="4"
                                    placeholder="Masukkan deskripsi maskapai...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                        value="1" {{ old('is_active', '1') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="is_active">
                                        Status Aktif
                                    </label>
                                </div>
                                <small class="text-muted">Maskapai aktif akan ditampilkan di sistem pemesanan</small>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-1"></i> Simpan
                                </button>
                                <button type="reset" class="btn btn-outline-secondary">
                                    <i class="bx bx-refresh me-1"></i> Reset
                                </button>
                                <a href="{{ route('admin.airlines.index') }}" class="btn btn-outline-dark">
                                    <i class="bx bx-x me-1"></i> Batal
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Convert code to uppercase on input
        document.getElementById('code').addEventListener('input', function (e) {
            e.target.value = e.target.value.toUpperCase();
        });
    </script>
@endpush