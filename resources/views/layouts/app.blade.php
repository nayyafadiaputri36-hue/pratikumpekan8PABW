<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SiPustaka') · SiPustaka</title>
  @include('layouts.assets')
</head>
<body class="bg-paper text-ink font-body min-h-screen">
@php $u = auth()->user(); $nav = fn ($p) => request()->routeIs($p) ? 'bg-white/15 text-white' : 'text-white/70 hover:text-white hover:bg-white/10'; @endphp
<div class="md:flex min-h-screen">
  <aside class="md:w-64 bg-spruce text-white p-5 md:sticky md:top-0 md:h-screen flex md:flex-col gap-4 items-center md:items-stretch justify-between md:justify-start">
    <a href="{{ route('dashboard') }}" class="font-display text-2xl font-bold flex items-center gap-2">
      <span class="h-7 w-5 rounded-sm bg-amber inline-block"></span>SiPustaka
    </a>
    <nav class="flex md:flex-col gap-1 text-sm font-semibold md:mt-6">
      <a class="px-3 py-2 rounded-lg {{ $nav('dashboard') }}" href="{{ route('dashboard') }}">Ringkasan</a>
      <a class="px-3 py-2 rounded-lg {{ $nav('books.*') }}" href="{{ route('books.index') }}">Buku</a>
      <a class="px-3 py-2 rounded-lg {{ $nav('loans.*') }}" href="{{ route('loans.index') }}">Peminjaman</a>
      @if($u->role === 'admin')
        <a class="px-3 py-2 rounded-lg {{ $nav('users.*') }}" href="{{ route('users.index') }}">Pengguna</a>
      @endif
    </nav>
    <div class="hidden md:block mt-auto text-sm">
      <p class="font-semibold">{{ $u->name }}</p>
      <p class="text-white/60 mb-3">{{ $u->role === 'admin' ? 'Administrator' : 'Anggota' }}</p>
      <form method="POST" action="{{ route('logout') }}">@csrf<button class="w-full rounded-lg border border-white/25 py-2 hover:bg-white/10">Keluar</button></form>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="md:hidden">@csrf<button class="text-sm underline">Keluar</button></form>
  </aside>

  <main class="flex-1 p-5 md:p-10 max-w-6xl">
    @if(session('success'))<div class="mb-5 rounded-lg bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm" role="status">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="mb-5 rounded-lg bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 text-sm" role="alert">{{ session('error') }}</div>@endif
    @yield('content')
  </main>
</div>
<div id="toast" class="fixed bottom-5 right-5 hidden rounded-lg bg-ink text-white px-4 py-3 text-sm shadow-lg"></div>
@stack('scripts')
</body>
</html>
