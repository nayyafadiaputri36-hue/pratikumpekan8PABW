
@extends('layouts.app')

@section('title', 'Peminjaman Buku')

@section('content')
<div class="container-fluid p-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold">Peminjaman Buku</h3>
            <p class="text-secondary">Kelola peminjaman buku SiPustaka.</p>
        </div>

        <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('user.dashboard') }}"
           class="btn btn-outline-success">
            Kembali ke Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="pesan"></div>

    <div class="card card-custom p-4 mb-4">
        <h5 class="fw-bold mb-3">Form Peminjaman Buku</h5>

        <form id="formPeminjaman">
            @csrf

            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Pilih Buku</label>
                    <select name="book_id" class="form-select" required>
                        <option value="">-- Pilih Buku --</option>
                        @foreach($books as $book)
                            <option value="{{ $book->id }}">
                                {{ $book->judul }} (Stok: {{ $book->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Tanggal Pinjam</label>
                    <input type="date"
                           name="tanggal_pinjam"
                           class="form-control"
                           value="{{ date('Y-m-d') }}"
                           required>
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-plus-circle"></i> Pinjam Buku
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="card card-custom p-4">
        <h5 class="fw-bold mb-3">Daftar Peminjaman</h5>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody id="daftarPeminjaman">
                    @forelse($peminjamans as $item)
                        <tr>
                            <td>{{ $peminjamans->firstItem() + $loop->index }}</td>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $item->book->judul }}</td>
                            <td>{{ $item->tanggal_pinjam->format('d-m-Y') }}</td>
                            <td>
                                @if($item->status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">Dipinjam</span>
                                @else
                                    <span class="badge bg-success">Dikembalikan</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status === 'dipinjam')
                                    <button
                                        class="btn btn-sm btn-primary"
                                        onclick="kembalikanBuku({{ $item->id }})">
                                        Kembalikan
                                    </button>
                                @else
                                    <span class="text-success">Selesai</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-secondary">
                                Belum ada data peminjaman.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $peminjamans->links() }}
    </div>
</div>

<script>
    const formPeminjaman = document.getElementById('formPeminjaman');
    const pesan = document.getElementById('pesan');

    formPeminjaman.addEventListener('submit', async function(e) {
        e.preventDefault();

        const tombol = formPeminjaman.querySelector('button[type="submit"]');
        tombol.disabled = true;

        try {
            const response = await fetch("{{ route('peminjaman.store') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: new FormData(formPeminjaman)
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Peminjaman gagal.');
            }

            pesan.innerHTML = `
                <div class="alert alert-success">${result.message}</div>
            `;

            window.location.reload();

        } catch (error) {
            pesan.innerHTML = `
                <div class="alert alert-danger">${error.message}</div>
            `;
        } finally {
            tombol.disabled = false;
        }
    });

    async function kembalikanBuku(id) {
        if (!confirm('Yakin ingin mengembalikan buku ini?')) return;

        try {
            const response = await fetch(`/peminjaman/${id}/kembalikan`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            const result = await response.json();

            if (!response.ok) {
                throw new Error(result.message || 'Pengembalian gagal.');
            }

            alert(result.message);
            window.location.reload();

        } catch (error) {
            alert(error.message);
        }
    }
</script>
@endsection
