@extends('layouts.main')
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
            <h3 class="text-left text-dark mb-0">Kelola Data Pengguna</h3>
            <a href="{{ route('user.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pengguna
            </a>
        </div>
        <hr>
        <div class="card p-3 shadow-sm">
            <table class="table table-bordered align-middle">
                <thead class="thead-light text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pengguna</th>
                        <th>Level</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($items as $item)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td class="text-left">
                                <div class="d-flex align-items-center">
                                    <img src="https://www.gravatar.com/avatar/{{ md5(strtolower(trim($item->email))) }}?s=40&d=identicon"
                                        alt="avatar" class="rounded-circle me-2" width="40" height="40">
                                    <div>
                                        <span class="fw-semibold">{{ $item->name }}</span><br>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if ($item->roles == 'admin')
                                    <span class="badge bg-success text-uppercase px-3 py-2">admin</span>
                                @else
                                    <span class="badge bg-primary text-uppercase px-3 py-2">developer</span>
                                @endif
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->status == 'aktif')
                                    <span class="badge bg-success px-3 py-2">Aktif</span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('user.edit', $item->id) }}"
                                        class="btn btn-sm btn-outline-primary me-2">
                                        <i class="bi bi-pencil-square"></i> Sunting
                                    </a>
                                    <form action="{{ route('user.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">Data tidak tersedia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS Dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.0.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@endsection
