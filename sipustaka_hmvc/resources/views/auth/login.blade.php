@extends('layouts.app')

@section('title', 'Login')

@section('content')

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">

    <div class="row card-custom overflow-hidden bg-white w-100" style="max-width: 950px;">

        <div class="col-md-6 p-5 text-white d-flex flex-column justify-content-center"
             style="background:linear-gradient(145deg,#1b4332,#40916c);">

            <div class="mb-4">
                <i class="bi bi-book-half fs-1"></i>
                <h2 class="fw-bold mt-3">SiPustaka</h2>
                <p class="opacity-75">Sistem Informasi Perpustakaan Digital</p>
            </div>

            <h3 class="fw-bold">Selamat Datang!</h3>

            <p class="opacity-75">
                Temukan buku favoritmu, kelola peminjaman,
                dan nikmati kemudahan membaca dalam satu aplikasi.
            </p>

            <i class="bi bi-journal-bookmark fs-1 mt-4"></i>
        </div>

        <div class="col-md-6 p-5">

            <h3 class="brand mb-2">Login Akun</h3>
            <p class="text-secondary mb-4">
                Silakan masuk untuk melanjutkan.
            </p>

            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email"
                        class="form-control form-control-lg"
                        placeholder="Masukkan email"
                        value="{{ old('email') }}" required>
                </div>

                <div class="mb-4">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                        class="form-control form-control-lg"
                        placeholder="Masukkan password" required>
                </div>

                <button class="btn btn-green w-100">
                    Masuk <i class="bi bi-arrow-right"></i>
                </button>
            </form>

            <p class="text-center mt-4 text-secondary">
                Belum punya akun?
                <a href="{{ route('register') }}"
                   class="text-success fw-bold text-decoration-none">
                    Daftar sekarang
                </a>
            </p>

        </div>
    </div>
</div>

@endsection