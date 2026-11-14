
@extends('layouts.app')

@section('title', 'Data Pengguna')

@section('content')

<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Data Pengguna</h3>
            <p class="text-secondary">Kelola akun pengguna SiPustaka.</p>
        </div>

        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-success">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORM TAMBAH PENGGUNA --}}
    <div class="card card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3">Tambah Pengguna</h5>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                           class="form-control" required minlength="6">
                </div>

                <div class="col-md-2">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-select" required>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Tambah
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABEL PENGGUNA --}}
    <div class="card card-custom p-4">
        <h5 class="fw-bold mb-3">Daftar Pengguna</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal Daftar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role === 'admin')
                                    <span class="badge bg-success">Admin</span>
                                @else
                                    <span class="badge bg-primary">User</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d-m-Y') }}</td>
                            <td>
                                <button type="button"
                                        class="btn btn-warning btn-sm"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal{{ $user->id }}">
                                    <i class="bi bi-pencil"></i> Edit
                                </button>

                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}"
                                          method="POST"
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>

                        {{-- MODAL EDIT --}}
                        <div class="modal fade" id="editModal{{ $user->id }}"
                             tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">

                                    <form action="{{ route('users.update', $user->id) }}"
                                          method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Pengguna</h5>
                                            <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Nama</label>
                                                <input type="text" name="name"
                                                       class="form-control"
                                                       value="{{ $user->name }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email"
                                                       class="form-control"
                                                       value="{{ $user->email }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Password Baru (Opsional)
                                                </label>
                                                <input type="password" name="password"
                                                       class="form-control"
                                                       minlength="6"
                                                       placeholder="Kosongkan jika tidak diubah">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Role</label>
                                                <select name="role" class="form-select" required>
                                                    <option value="user"
                                                        {{ $user->role === 'user' ? 'selected' : '' }}>
                                                        User
                                                    </option>
                                                    <option value="admin"
                                                        {{ $user->role === 'admin' ? 'selected' : '' }}>
                                                        Admin
                                                    </option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Batal
                                            </button>

                                            <button type="submit" class="btn btn-success">
                                                Simpan Perubahan
                                            </button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $users->links() }}
    </div>

</div>

@endsection
