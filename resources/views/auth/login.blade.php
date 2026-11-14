<!DOCTYPE html>
<html lang="id"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Masuk ke SiPustaka</title>@include('layouts.assets')</head>
<body class="font-body bg-paper text-ink min-h-screen grid md:grid-cols-2">
  <section class="hidden md:flex bg-spruce text-white p-12 flex-col justify-between">
    <p class="font-display text-2xl font-bold flex items-center gap-2"><span class="h-7 w-5 rounded-sm bg-amber inline-block"></span>SiPustaka</p>
    <div>
      <h1 class="font-display text-5xl font-extrabold leading-tight">Satu rak, semua<br>peminjaman tercatat.</h1>
      <p class="mt-4 text-white/70 max-w-sm">Kelola dan pinjam koleksi perpustakaan kampus.</p>
    </div>
    <div class="flex gap-1 items-end h-24">@foreach([60,90,72,100,66,84,95] as $h)<span class="w-6 rounded-t-sm bg-white/15 border-t-4 border-amber" style="height: {{ $h }}%"></span>@endforeach</div>
  </section>
  <section class="flex items-center justify-center p-6">
    <form method="POST" action="{{ route('login') }}" class="w-full max-w-sm grid gap-4">
      @csrf
      <h2 class="font-display text-3xl font-bold">Masuk ke SiPustaka</h2>
      @if(session('success'))<p class="rounded-lg bg-emerald-50 text-emerald-800 text-sm px-3 py-2">{{ session('success') }}</p>@endif
      <div><label class="label">Email</label><input name="email" type="email" value="{{ old('email') }}" class="input">@error('email')<p class="err">{{ $message }}</p>@enderror</div>
    <div><label class="label">Kata sandi</label><input name="password" type="password" class="input">@error('password')<p class="err">{{ $message }}</p>@enderror</div>
    <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember"> Ingat saya</label>
      <button class="btn-primary justify-center py-2.5">Masuk</button>
      <p class="text-sm text-ink/70">Belum punya akun? <a class="font-semibold text-spruce underline" href="{{ route('register') }}">Daftar</a></p>
    </form>
  </section>
</body></html>
