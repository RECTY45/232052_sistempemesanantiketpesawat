@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Edit Bandara</h4>
                        <p class="text-muted">Perbarui informasi bandara {{ $airport->name }}</p>
                    </div>
                    <a href="{{ route('admin.airports.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-2"></i>Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.airports.update', $airport) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <!-- Airport Code -->
                                <div class="col-md-4 mb-3">
                                    <label for="code" class="form-label">Kode IATA <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" id="code"
                                        name="code" value="{{ old('code', $airport->code) }}" placeholder="Contoh: CGK"
                                        maxlength="3" style="text-transform: uppercase" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kode 3 huruf IATA</small>
                                </div>

                                <!-- Airport Name -->
                                <div class="col-md-8 mb-3">
                                    <label for="name" class="form-label">Nama Bandara <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                        name="name" value="{{ old('name', $airport->name) }}"
                                        placeholder="Contoh: Soekarno-Hatta International Airport" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- City -->
                                <div class="col-md-6 mb-3">
                                    <label for="city" class="form-label">Kota <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                                        name="city" value="{{ old('city', $airport->city) }}" placeholder="Contoh: Jakarta"
                                        required>
                                    @error('city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Country -->
                                <div class="col-md-6 mb-3">
                                    <label for="country" class="form-label">Negara <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('country') is-invalid @enderror" id="country"
                                        name="country" required>
                                        <option value="">Pilih Negara</option>
                                        <option value="Indonesia" {{ old('country', $airport->country) == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                        <option value="Malaysia" {{ old('country', $airport->country) == 'Malaysia' ? 'selected' : '' }}>Malaysia</option>
                                        <option value="Singapore" {{ old('country', $airport->country) == 'Singapore' ? 'selected' : '' }}>Singapore</option>
                                        <option value="Thailand" {{ old('country', $airport->country) == 'Thailand' ? 'selected' : '' }}>Thailand</option>
                                        <option value="Philippines" {{ old('country', $airport->country) == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                                        <option value="Vietnam" {{ old('country', $airport->country) == 'Vietnam' ? 'selected' : '' }}>Vietnam</option>
                                    </select>
                                    @error('country')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Latitude -->
                                <div class="col-md-6 mb-3">
                                    <label for="latitude" class="form-label">Latitude</label>
                                    <input type="number" class="form-control @error('latitude') is-invalid @enderror"
                                        id="latitude" name="latitude" value="{{ old('latitude', $airport->latitude) }}"
                                        step="0.000001" placeholder="Contoh: -6.125567">
                                    @error('latitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Longitude -->
                                <div class="col-md-6 mb-3">
                                    <label for="longitude" class="form-label">Longitude</label>
                                    <input type="number" class="form-control @error('longitude') is-invalid @enderror"
                                        id="longitude" name="longitude" value="{{ old('longitude', $airport->longitude) }}"
                                        step="0.000001" placeholder="Contoh: 106.655897">
                                    @error('longitude')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Timezone -->
                                <div class="col-md-12 mb-3">
                                    <label for="timezone" class="form-label">Zona Waktu <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('timezone') is-invalid @enderror" id="timezone"
                                        name="timezone" required>
                                        <option value="">Pilih Zona Waktu</option>
                                        <option value="Asia/Jakarta" {{ old('timezone', $airport->timezone) == 'Asia/Jakarta' ? 'selected' : '' }}>WIB (UTC+7) - Asia/Jakarta</option>
                                        <option value="Asia/Makassar" {{ old('timezone', $airport->timezone) == 'Asia/Makassar' ? 'selected' : '' }}>WITA (UTC+8) -
                                            Asia/Makassar</option>
                                        <option value="Asia/Jayapura" {{ old('timezone', $airport->timezone) == 'Asia/Jayapura' ? 'selected' : '' }}>WIT (UTC+9) -
                                            Asia/Jayapura</option>
                                    </select>
                                    @error('timezone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-4">
                                <label for="is_active" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                                    name="is_active" required>
                                    <option value="1" {{ old('is_active', $airport->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $airport->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Bandara aktif dapat menerima jadwal penerbangan</small>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.airports.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-2"></i>Update Bandara
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto uppercase for airport code
        document.getElementById('code').addEventListener('input', function () {
            this.value = this.value.toUpperCase();
        });
    </script>

@endsection