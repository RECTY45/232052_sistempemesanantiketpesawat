@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h4 class="fw-bold py-3 mb-2">Tambah Pesawat Baru</h4>
                        <p class="text-muted">Masukkan detail pesawat yang akan ditambahkan</p>
                    </div>
                    <a href="{{ route('admin.aircraft.index') }}" class="btn btn-outline-secondary">
                        <i class="bx bx-arrow-back me-2"></i>Kembali
                    </a>
                </div>

                <!-- Form Card -->
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.aircraft.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <!-- Aircraft Registration -->
                                <div class="col-md-6 mb-3">
                                    <label for="registration" class="form-label">Registrasi Pesawat <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('registration') is-invalid @enderror"
                                        id="registration" name="registration" value="{{ old('registration') }}"
                                        placeholder="Contoh: PK-ABC" required>
                                    @error('registration')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kode registrasi unik untuk identifikasi pesawat</small>
                                </div>

                                <!-- Airline -->
                                <div class="col-md-6 mb-3">
                                    <label for="airline_id" class="form-label">Maskapai <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('airline_id') is-invalid @enderror" id="airline_id"
                                        name="airline_id" required>
                                        <option value="">Pilih Maskapai</option>
                                        @foreach($airlines as $airline)
                                            <option value="{{ $airline->id }}" {{ old('airline_id') == $airline->id ? 'selected' : '' }}>
                                                {{ $airline->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('airline_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Model -->
                                <div class="col-md-6 mb-3">
                                    <label for="model" class="form-label">Model Pesawat <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('model') is-invalid @enderror" id="model"
                                        name="model" value="{{ old('model') }}" placeholder="Contoh: Boeing 737-800"
                                        required>
                                    @error('model')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Economy Seats -->
                                <div class="col-md-4 mb-3">
                                    <label for="economy_seats" class="form-label">Kursi Ekonomi <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('economy_seats') is-invalid @enderror"
                                        id="economy_seats" name="economy_seats" value="{{ old('economy_seats', 0) }}"
                                        min="0" placeholder="Contoh: 150" required>
                                    @error('economy_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Business Seats -->
                                <div class="col-md-4 mb-3">
                                    <label for="business_seats" class="form-label">Kursi Bisnis</label>
                                    <input type="number" class="form-control @error('business_seats') is-invalid @enderror"
                                        id="business_seats" name="business_seats" value="{{ old('business_seats', 0) }}"
                                        min="0" placeholder="Contoh: 20">
                                    @error('business_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- First Class Seats -->
                                <div class="col-md-4 mb-3">
                                    <label for="first_class_seats" class="form-label">Kursi First Class</label>
                                    <input type="number"
                                        class="form-control @error('first_class_seats') is-invalid @enderror"
                                        id="first_class_seats" name="first_class_seats"
                                        value="{{ old('first_class_seats', 0) }}" min="0" placeholder="Contoh: 8">
                                    @error('first_class_seats')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="row">
                                <!-- Status -->
                                <div class="col-md-6 mb-3">
                                    <label for="is_active" class="form-label">Status <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select @error('is_active') is-invalid @enderror" id="is_active"
                                        name="is_active" required>
                                        <option value="">Pilih Status</option>
                                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Non-Aktif</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <label for="description" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="3"
                                    placeholder="Deskripsi tambahan tentang pesawat (opsional)">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.aircraft.index') }}" class="btn btn-outline-secondary">
                                    Batal
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-save me-2"></i>Simpan Pesawat
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection