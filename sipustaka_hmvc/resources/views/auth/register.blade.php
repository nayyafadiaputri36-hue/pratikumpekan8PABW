@extends('layouts.app')

@section('title', 'Register')

@section('content')

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">

    <div class="card card-custom p-4 p-md-5 w-100" style="max-width:520px;">

        <div class="text-center mb-4">
            <i class="bi bi-book-half brand fs-1"></i>
            <h2 class="brand mt-2">SiPustaka</h2>
            <p class="text-secondary">Buat akun perpustakaan kamu</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('register.process') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control"
                    placeholder="Nama lengkap" value="{{ old('name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control"
                    placeholder="Alamat email" value="{{ old('email') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-4">
                <label class="form-label">Konfirmasi Password</label>
                <input type="password" name="password_confirmation"
                    class="form-control" placeholder="Ulangi password" required>
            </div>

            <button class="btn btn-green w-100">
                Daftar Sekarang
            </button>
        </form>

        <p class="text-center mt-4 text-secondary">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-success fw-bold">
                Login
            </a>
        </p>

    </div>
</div>

@endsection