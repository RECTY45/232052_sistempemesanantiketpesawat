@extends('layouts.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-10 mx-auto">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold py-3 mb-2">Edit Penerbangan</h4>
                    <p class="text-muted">Perbarui informasi penerbangan {{ $flight->flight_number }}</p>
                </div>
                <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-secondary">
                    <i class="bx bx-arrow-back me-2"></i>Kembali
                </a>
            </div>

            <!-- Form Card -->
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.flights.update', $flight) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Flight Information -->
                        <h6 class="fw-bold mb-3 text-primary">Informasi Penerbangan</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="flight_number" class="form-label">Nomor Penerbangan <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control @error('flight_number') is-invalid @enderror" 
                                       id="flight_number" 
                                       name="flight_number" 
                                       value="{{ old('flight_number', $flight->flight_number) }}" 
                                       placeholder="Contoh: GA123"
                                       required>
                                @error('flight_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="airline_id" class="form-label">Maskapai <span class="text-danger">*</span></label>
                                <select class="form-select @error('airline_id') is-invalid @enderror" 
                                        id="airline_id" 
                                        name="airline_id" 
                                        required>
                                    <option value="">Pilih Maskapai</option>
                                    @foreach($airlines as $airline)
                                        <option value="{{ $airline->id }}" 
                                                {{ old('airline_id', $flight->airline_id) == $airline->id ? 'selected' : '' }}>
                                            {{ $airline->name }} ({{ $airline->code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('airline_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="aircraft_id" class="form-label">Pesawat <span class="text-danger">*</span></label>
                                <select class="form-select @error('aircraft_id') is-invalid @enderror" 
                                        id="aircraft_id" 
                                        name="aircraft_id" 
                                        required>
                                    <option value="">Pilih Pesawat</option>
                                    @foreach($aircraft as $plane)
                                        <option value="{{ $plane->id }}" 
                                                data-capacity="{{ $plane->capacity }}"
                                                {{ old('aircraft_id', $flight->aircraft_id) == $plane->id ? 'selected' : '' }}>
                                            {{ $plane->aircraft_code }} - {{ $plane->model }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('aircraft_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Route Information -->
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3 text-primary">Rute Penerbangan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="departure_airport_id" class="form-label">Bandara Keberangkatan <span class="text-danger">*</span></label>
                                <select class="form-select @error('departure_airport_id') is-invalid @enderror" 
                                        id="departure_airport_id" 
                                        name="departure_airport_id" 
                                        required>
                                    <option value="">Pilih Bandara Keberangkatan</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" 
                                                {{ old('departure_airport_id', $flight->departure_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->code }} - {{ $airport->name }} ({{ $airport->city }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('departure_airport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="arrival_airport_id" class="form-label">Bandara Tujuan <span class="text-danger">*</span></label>
                                <select class="form-select @error('arrival_airport_id') is-invalid @enderror" 
                                        id="arrival_airport_id" 
                                        name="arrival_airport_id" 
                                        required>
                                    <option value="">Pilih Bandara Tujuan</option>
                                    @foreach($airports as $airport)
                                        <option value="{{ $airport->id }}" 
                                                {{ old('arrival_airport_id', $flight->arrival_airport_id) == $airport->id ? 'selected' : '' }}>
                                            {{ $airport->code }} - {{ $airport->name }} ({{ $airport->city }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('arrival_airport_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Schedule -->
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3 text-primary">Jadwal Penerbangan</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="departure_time" class="form-label">Waktu Keberangkatan <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       class="form-control @error('departure_time') is-invalid @enderror" 
                                       id="departure_time" 
                                       name="departure_time" 
                                       value="{{ old('departure_time', $flight->departure_time->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('departure_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="arrival_time" class="form-label">Waktu Tiba <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       class="form-control @error('arrival_time') is-invalid @enderror" 
                                       id="arrival_time" 
                                       name="arrival_time" 
                                       value="{{ old('arrival_time', $flight->arrival_time->format('Y-m-d\TH:i')) }}" 
                                       required>
                                @error('arrival_time')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="gate" class="form-label">Gate</label>
                                <input type="text" 
                                       class="form-control @error('gate') is-invalid @enderror" 
                                       id="gate" 
                                       name="gate" 
                                       value="{{ old('gate', $flight->gate) }}" 
                                       placeholder="Contoh: A1, B5"
                                       maxlength="10">
                                @error('gate')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select @error('status') is-invalid @enderror" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="scheduled" {{ old('status', $flight->status) == 'scheduled' ? 'selected' : '' }}>Terjadwal</option>
                                    <option value="delayed" {{ old('status', $flight->status) == 'delayed' ? 'selected' : '' }}>Tertunda</option>
                                    <option value="cancelled" {{ old('status', $flight->status) == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                                    <option value="completed" {{ old('status', $flight->status) == 'completed' ? 'selected' : '' }}>Selesai</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="is_active" class="form-label">Status Aktif</label>
                                <select class="form-select @error('is_active') is-invalid @enderror" 
                                        id="is_active" 
                                        name="is_active">
                                    <option value="1" {{ old('is_active', $flight->is_active ? '1' : '0') == '1' ? 'selected' : '' }}>Aktif</option>
                                    <option value="0" {{ old('is_active', $flight->is_active ? '1' : '0') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('is_active')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Pricing -->
                        <hr class="my-4">
                        <h6 class="fw-bold mb-3 text-primary">Harga Tiket</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="economy_price" class="form-label">Harga Economy <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('economy_price') is-invalid @enderror" 
                                           id="economy_price" 
                                           name="economy_price" 
                                           value="{{ old('economy_price', $flight->economy_price) }}" 
                                           min="0"
                                           step="0.01"
                                           placeholder="0"
                                           required>
                                </div>
                                @error('economy_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="business_price" class="form-label">Harga Business</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('business_price') is-invalid @enderror" 
                                           id="business_price" 
                                           name="business_price" 
                                           value="{{ old('business_price', $flight->business_price) }}" 
                                           min="0"
                                           step="0.01"
                                           placeholder="0">
                                </div>
                                @error('business_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="first_class_price" class="form-label">Harga First Class</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           class="form-control @error('first_class_price') is-invalid @enderror" 
                                           id="first_class_price" 
                                           name="first_class_price" 
                                           value="{{ old('first_class_price', $flight->first_class_price) }}" 
                                           min="0"
                                           step="0.01"
                                           placeholder="0">
                                </div>
                                @error('first_class_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.flights.index') }}" class="btn btn-outline-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-2"></i>Update Penerbangan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-fill available seats based on selected aircraft
document.getElementById('aircraft_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const capacity = selectedOption.getAttribute('data-capacity');
    
    // Note: This script needs to be updated to work with the new pricing structure
    if (capacity) {
        // Set economy seats as 70% of capacity
        const economySeats = Math.floor(capacity * 0.7);
        const businessSeats = Math.floor(capacity * 0.25);
        const firstClassSeats = Math.floor(capacity * 0.05);
        
        // Update price fields to suggest based on aircraft type
        console.log('Selected aircraft capacity:', capacity);
    }
});
</script>

@endsection
