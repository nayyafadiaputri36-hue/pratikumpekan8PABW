
@extends('layouts.app')

@section('title', 'Data Buku')

@section('content')

<div class="container-fluid">
    <div class="row">

        <!-- SIDEBAR -->
        <div class="col-md-2 sidebar p-4">
            <h3 class="fw-bold mb-5">
                <i class="bi bi-book-half"></i> SiPustaka
            </h3>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            @else
                <a href="{{ route('user.dashboard') }}">
                    <i class="bi bi-grid"></i> Dashboard
                </a>
            @endif

            <a href="{{ route('buku.index') }}">
                <i class="bi bi-book"></i> Data Buku
            </a>

            <a href="#">
                <i class="bi bi-arrow-left-right"></i> Peminjaman
            </a>

            @if(auth()->user()->role === 'admin')
                <a href="#">
                    <i class="bi bi-people"></i> Pengguna
                </a>
            @endif

            <form action="{{ route('logout') }}" method="POST" class="mt-5">
                @csrf
                <button class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        <!-- KONTEN -->
        <div class="col-md-10 p-4 p-md-5">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                <div>
                    <h3 class="fw-bold">Koleksi Buku 📚</h3>
                    <p class="text-secondary mb-0">
                        Kelola dan lihat koleksi buku perpustakaan.
                    </p>
                </div>

                @if(auth()->user()->role === 'admin')
                    <button class="btn btn-green" data-bs-toggle="modal"
                            data-bs-target="#modalTambah">
                        <i class="bi bi-plus-circle"></i> Tambah Buku
                    </button>
                @endif
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="bi bi-check-circle"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close"
                            data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <strong>Periksa kembali data:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TABEL BUKU -->
            <div class="card card-custom p-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0">Daftar Buku</h5>
                    <span class="badge bg-success">
                        {{ $books->total() }} Buku
                    </span>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Judul Buku</th>
                                <th>Penulis</th>
                                <th>Penerbit</th>
                                <th>Tahun</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                                @if(auth()->user()->role === 'admin')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($books as $book)
                                <tr>
                                    <td>{{ $books->firstItem() + $loop->index }}</td>

                                    <td class="fw-semibold">
                                        {{ $book->judul }}
                                    </td>

                                    <td>{{ $book->penulis }}</td>
                                    <td>{{ $book->penerbit }}</td>
                                    <td>{{ $book->tahun_terbit }}</td>

                                    <td>
                                        <span class="badge bg-success-subtle text-success">
                                            {{ $book->kategori }}
                                        </span>
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark">
                                            {{ $book->stok }}
                                        </span>
                                    </td>

                                    @if(auth()->user()->role === 'admin')
                                        <td>
                                            <button class="btn btn-sm btn-warning"
                                                onclick="editBuku(
                                                    {{ $book->id }},
                                                    @js($book->judul),
                                                    @js($book->penulis),
                                                    @js($book->penerbit),
                                                    @js($book->tahun_terbit),
                                                    @js($book->kategori),
                                                    {{ $book->stok }}
                                                )">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <form action="{{ route('buku.destroy', $book->id) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-sm btn-danger">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-5">
                                        <i class="bi bi-book fs-1 text-secondary"></i>
                                        <p class="text-secondary mt-2">
                                            Belum ada data buku.
                                        </p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $books->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL TAMBAH -->
@if(auth()->user()->role === 'admin')
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header text-white"
                 style="background:#1b4332;">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-plus-circle"></i> Tambah Buku
                </h5>
                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('buku.store') }}" method="POST">
                @csrf

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit"
                            class="form-control" min="1000"
                            max="9999" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" class="form-select" required>
                            <option value="">Pilih Kategori</option>
                            <option>Novel</option>
                            <option>Pendidikan</option>
                            <option>Teknologi</option>
                            <option>Sejarah</option>
                            <option>Komik</option>
                            <option>Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok Buku</label>
                        <input type="number" name="stok"
                            class="form-control" min="0" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-green">
                        Simpan Buku
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4">

            <div class="modal-header text-white"
                 style="background:#1b4332;">
                <h5 class="modal-title fw-bold">Edit Data Buku</h5>
                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" id="editJudul"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="penulis" id="editPenulis"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Penerbit</label>
                        <input type="text" name="penerbit" id="editPenerbit"
                            class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit"
                            id="editTahun" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kategori</label>
                        <select name="kategori" id="editKategori"
                            class="form-select" required>
                            <option>Novel</option>
                            <option>Pendidikan</option>
                            <option>Teknologi</option>
                            <option>Sejarah</option>
                            <option>Komik</option>
                            <option>Umum</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Stok</label>
                        <input type="number" name="stok" id="editStok"
                            class="form-control" min="0" required>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-green">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editBuku(id, judul, penulis, penerbit, tahun, kategori, stok) {
    document.getElementById('formEdit').action = '/buku/' + id;

    document.getElementById('editJudul').value = judul;
    document.getElementById('editPenulis').value = penulis;
    document.getElementById('editPenerbit').value = penerbit;
    document.getElementById('editTahun').value = tahun;
    document.getElementById('editKategori').value = kategori;
    document.getElementById('editStok').value = stok;

    new bootstrap.Modal(document.getElementById('modalEdit')).show();
}
</script>

@endsection
