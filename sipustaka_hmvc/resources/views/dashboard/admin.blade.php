
@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar p-4">
            <h3 class="fw-bold mb-5">
                <i class="bi bi-book-half"></i> SiPustaka
            </h3>

            <a href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>

            <a href="{{ route('buku.index') }}">
                <i class="bi bi-book"></i> Data Buku
            </a>

            <a href="{{ route('peminjaman.index') }}">
                <i class="bi bi-arrow-left-right"></i> Peminjaman
            </a>

            <a href="{{ route('users.index') }}">
                <i class="bi bi-people"></i> Data Pengguna
            </a>

            <form action="{{ route('logout') }}" method="POST" class="mt-5">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </button>
            </form>
        </div>

        {{-- KONTEN DASHBOARD --}}
        <div class="col-md-10 p-4 p-md-5">

            <h3 class="fw-bold">Dashboard Admin 👋</h3>

            <p class="text-secondary">
                Selamat datang, {{ Auth::user()->name }}!
                Kelola perpustakaan dengan mudah.
            </p>

            {{-- KARTU STATISTIK --}}
            <div class="row g-4 mt-3">

                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-book fs-2 text-success"></i>
                        <h5 class="mt-3">Total Buku</h5>
                        <h2 class="fw-bold">{{ $totalBuku }}</h2>
                        <small class="text-secondary">
                            Koleksi perpustakaan
                        </small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-arrow-left-right fs-2 text-primary"></i>
                        <h5 class="mt-3">Peminjaman</h5>
                        <h2 class="fw-bold">{{ $totalPeminjaman }}</h2>
                        <small class="text-secondary">
                            Total peminjaman
                        </small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="stat-card">
                        <i class="bi bi-people fs-2 text-warning"></i>
                        <h5 class="mt-3">Pengguna</h5>
                        <h2 class="fw-bold">{{ $totalPengguna }}</h2>
                        <small class="text-secondary">
                            Akun terdaftar
                        </small>
                    </div>
                </div>

            </div>

            {{-- MENU PENGELOLAAN --}}
            <div class="card card-custom p-4 mt-4">
                <h5 class="fw-bold">
                    Selamat Mengelola SiPustaka!
                </h5>

                <p class="text-secondary mb-0">
                    Gunakan menu berikut untuk mengelola
                    buku, peminjaman, dan pengguna perpustakaan.
                </p>

                <div class="mt-3 d-flex flex-wrap gap-2">

                    <a href="{{ route('buku.index') }}"
                       class="btn btn-success">
                        <i class="bi bi-book"></i>
                        Kelola Data Buku
                    </a>

                    <a href="{{ route('peminjaman.index') }}"
                       class="btn btn-primary">
                        <i class="bi bi-arrow-left-right"></i>
                        Kelola Peminjaman
                    </a>

                    <a href="{{ route('users.index') }}"
                       class="btn btn-warning">
                        <i class="bi bi-people"></i>
                        Kelola Pengguna
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

@endsection
