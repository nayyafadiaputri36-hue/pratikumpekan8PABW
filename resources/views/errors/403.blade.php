<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>403 · Akses ditolak</title>@include('layouts.assets')</head>
<body class="font-body bg-paper text-ink min-h-screen flex items-center justify-center p-6">
  <div class="text-center max-w-md">
    <p class="font-display text-8xl font-extrabold text-spruce">403</p>
    <h1 class="font-display text-2xl font-bold mt-2">Akses ditolak</h1>
    <p class="text-ink/60 mt-2">{{ $exception->getMessage() ?: 'Anda tidak memiliki izin untuk membuka halaman ini.' }}</p>
    <a href="{{ url('/dashboard') }}" class="btn-primary mt-6">Kembali ke ringkasan</a>
  </div>
</body></html>
