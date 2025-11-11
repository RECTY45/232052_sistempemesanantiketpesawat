@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold py-3 mb-2">Edit Pesawat</h4>
                    <p class="text-muted">Perbarui informasi pesawat {{ $aircraft->registration }}</p>
                </div>
                <a href="{{ route('admin.aircraft.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-2"></i>Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.aircraft.update', $aircraft) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <!-- Aircraft Registration -->
                            <div class="col-md-6 mb-3">
                                <label for="registration" class="form-label">Registrasi Pesawat <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('registration') is-invalid @enderror" 
                                       id="registration" 
                                       name="registration" 
                                       value="{{ old('registration', $aircraft->registration) }}" 
                                       placeholder="Contoh: PK-ABC"
                                       required>
                                @error('registration')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kode registrasi unik untuk identifikasi pesawat</small>
                            </div>

                            <!-- Airline -->
                            <div class="col-md-6 mb-3">
                                <label for="airline_id" class="form-label">Maskapai <span class="text-danger">*</span></label>
                                <select class="form-select @error('airline_id') is-invalid @enderror" 
                                        id="airline_id" 
                                        name="airline_id" 
                                        required>
                                    <option value="">Pilih Maskapai</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}" 
                                                {{ old('airline_id', $aircraft->airline_id) == $airline->id ? 'selected' : '' }}>
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
                                <label for="model" class="form-label">Model Pesawat <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('model') is-invalid @enderror" 
                                       id="model" 
                                       name="model" 
                                       value="{{ old('model', $aircraft->model) }}" 
                                       placeholder="Contoh: Boeing 737-800"
                                       required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Manufacturer -->
                            <div class="col-md-6 mb-3">
                                <label for="manufacturer" class="form-label">Pabrik Pembuat <span class="text-danger">*</span></label>
                                <select class="form-select @error('manufacturer') is-invalid @enderror" 
                                        id="manufacturer" 
                                        name="manufacturer" 
                                        required>
                                    <option value="">Pilih Pabrik</option>
                                    <option value="Boeing" {{ old('manufacturer', $aircraft->manufacturer) == 'Boeing' ? 'selected' : '' }}>Boeing</option>
                                    <option value="Airbus" {{ old('manufacturer', $aircraft->manufacturer) == 'Airbus' ? 'selected' : '' }}>Airbus</option>
                                    <option value="ATR" {{ old('manufacturer', $aircraft->manufacturer) == 'ATR' ? 'selected' : '' }}>ATR</option>
                                    <option value="Bombardier" {{ old('manufacturer', $aircraft->manufacturer) == 'Bombardier' ? 'selected' : '' }}>Bombardier</option>
                                    <option value="Embraer" {{ old('manufacturer', $aircraft->manufacturer) == 'Embraer' ? 'selected' : '' }}>Embraer</option>
                                </select>
                                @error('manufacturer')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <!-- Capacity -->
                            <div class="col-md-6 mb-3">
                                <label for="capacity" class="form-label">Kapasitas Penumpang <span class="text-danger">*</span></label>
                                <input type="number" 
                                       class="form-control @error('capacity') is-invalid @enderror" 
                                       id="capacity" 
                                       name="capacity" 
                                       value="{{ old('capacity', $aircraft->capacity) }}" 
                                       min="1" 
                                       max="1000"
                                       placeholder="Contoh: 189"
                                       required>
                                @error('capacity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="active" {{ old('status', $aircraft->status) == 'active' ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ old('status', $aircraft->status) == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="3" 
                                      placeholder="Deskripsi tambahan tentang pesawat (opsional)">{{ old('description', $aircraft->description) }}</textarea>
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
                                <i class="bx bx-save me-2"></i>Update Pesawat
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
