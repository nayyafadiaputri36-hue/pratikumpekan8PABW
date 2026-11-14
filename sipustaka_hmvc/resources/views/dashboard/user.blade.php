
@extends('layouts.app')

@section('title', 'Dashboard User')

@section('content')

<div class="container-fluid">
    <div class="row">

        {{-- SIDEBAR --}}
        <div class="col-md-2 sidebar p-4">
            <h3 class="fw-bold mb-5">
                <i class="bi bi-book-half"></i> SiPustaka
            </h3>

            <a href="{{ route('user.dashboard') }}">
                <i class="bi bi-grid"></i> Dashboard
            </a>

            <a href="{{ route('buku.index') }}">
                <i class="bi bi-book"></i> Jelajahi Buku
            </a>

            <a href="{{ route('peminjaman.index') }}">
                <i class="bi bi-clock-history"></i> Riwayat Peminjaman
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

            <h3 class="fw-bold">
                Halo, {{ Auth::user()->name }}! 👋
            </h3>

            <p class="text-secondary">
                Selamat datang di perpustakaan digital SiPustaka.
            </p>

            {{-- BANNER --}}
            <div class="card card-custom p-4 mt-4"
                 style="background:linear-gradient(120deg,#1b4332,#40916c);color:white;">

                <h2 class="fw-bold">Temukan Buku Favoritmu!</h2>

                <p>
                    Jelajahi berbagai koleksi buku dan nikmati
                    pengalaman membaca yang lebih mudah.
                </p>

                <a href="{{ route('buku.index') }}"
                   class="btn btn-light text-success fw-bold"
                   style="width:180px;">
                    <i class="bi bi-search"></i> Jelajahi Buku
                </a>
            </div>

            {{-- KARTU MENU --}}
            <div class="row mt-4 g-4">

                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="bi bi-book fs-2 text-success"></i>

                        <h5 class="mt-3">Koleksi Buku</h5>

                        <p class="text-secondary">
                            Lihat berbagai buku yang tersedia di perpustakaan.
                        </p>

                        <a href="{{ route('buku.index') }}"
                           class="btn btn-outline-success">
                            Lihat Buku
                        </a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="stat-card">
                        <i class="bi bi-clock-history fs-2 text-primary"></i>

                        <h5 class="mt-3">Peminjaman Saya</h5>

                        <p class="text-secondary">
                            Pantau riwayat peminjaman dan pengembalian buku.
                        </p>

                        <a href="{{ route('peminjaman.index') }}"
                           class="btn btn-outline-primary">
                            Lihat Riwayat
                        </a>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

@endsection
