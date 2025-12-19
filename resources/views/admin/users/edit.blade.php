@extends('layouts.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold py-3 mb-1">
                    <span class="text-muted fw-light">Master Data /</span> Sunting Pengguna
                </h4>
                <p class="text-muted">Perbarui informasi pengguna</p>
            </div>
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">
                <i class="bx bx-arrow-back me-1"></i> Kembali
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label for="name" class="col-sm-2 col-form-label">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}" required>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="phone" class="col-sm-2 col-form-label">Telepon</label>
                        <div class="col-sm-10">
                            <input type="tel" name="phone" id="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="roles" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-10">
                            <select name="roles" id="roles" class="form-select @error('roles') is-invalid @enderror" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('roles', $user->roles) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="customer" {{ old('roles', $user->roles) === 'customer' ? 'selected' : '' }}>Customer</option>
                            </select>
                            @error('roles') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password" class="col-sm-2 col-form-label">Password Baru</label>
                        <div class="col-sm-10">
                            <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror">
                            <div class="form-text">Kosongkan jika tidak ingin mengubah password</div>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="password_confirmation" class="col-sm-2 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-10">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-10 offset-sm-2">
                            <div class="form-check">
                                <input type="checkbox" name="email_verified" id="email_verified" value="1" class="form-check-input" {{ old('email_verified', $user->email_verified_at ? '1' : '') ? 'checked' : '' }}>
                                <label for="email_verified" class="form-check-label">Email sudah diverifikasi</label>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="status" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-10">
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Pilih Status</option>
                                <option value="aktif" {{ old('status', $user->status) === 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status', $user->status) === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                            @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-10 offset-sm-2">
                            <button class="btn btn-primary" type="submit"><i class="bx bx-save me-1"></i>Update</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
