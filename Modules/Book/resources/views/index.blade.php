@extends('layouts.app')
@section('title', 'Daftar Buku')
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4 mb-6">
  <div>
    <h1 class="font-display text-3xl font-bold">Koleksi buku</h1>
    <p class="text-ink/60 mt-1">{{ $books->total() }} judul tersedia di perpustakaan kampus.</p>
  </div>
  @if(auth()->user()->role === 'admin')
    <a href="{{ route('books.create') }}" class="btn-primary">Tambah buku</a>
  @endif
</div>

<form method="GET" class="mb-5 flex gap-2">
  <input name="q" value="{{ request('q') }}" placeholder="Cari judul, penulis, atau penerbit" class="input max-w-md">
  <button class="btn-ghost">Cari</button>
  @if(request('q'))<a href="{{ route('books.index') }}" class="btn-ghost">Reset</a>@endif
</form>

<div class="card overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-left text-ink/60 border-b border-line">
      <tr><th class="p-4">Buku</th><th class="p-4">Penerbit</th><th class="p-4">Tahun</th><th class="p-4">Stok</th>
      @if(auth()->user()->role === 'admin')<th class="p-4 text-right">Aksi</th>@endif</tr>
    </thead>
    <tbody>
    @forelse($books as $b)
      <tr class="border-b border-line last:border-0 hover:bg-paper/60">
        <td class="p-4 flex items-center gap-3">
          <span class="h-12 w-8 rounded-sm bg-spruce border-l-4 border-amber shrink-0"></span>
          <span><span class="block font-semibold">{{ $b->judul }}</span><span class="text-ink/60">{{ $b->penulis }}</span></span>
        </td>
        <td class="p-4">{{ $b->penerbit }}</td>
        <td class="p-4">{{ $b->tahun_terbit }}</td>
        <td class="p-4"><span class="badge {{ $b->stok > 0 ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">{{ $b->stok > 0 ? $b->stok.' tersedia' : 'Habis' }}</span></td>
        @if(auth()->user()->role === 'admin')
        <td class="p-4 text-right whitespace-nowrap">
          <a href="{{ route('books.edit', $b) }}" class="text-spruce font-semibold hover:underline">Ubah</a>
          <form action="{{ route('books.destroy', $b) }}" method="POST" class="inline" onsubmit="return confirm('Hapus buku ini?')">
            @csrf @method('DELETE')
            <button class="ml-3 text-rose-600 font-semibold hover:underline">Hapus</button>
          </form>
        </td>
        @endif
      </tr>
    @empty
      <tr><td colspan="5" class="p-10 text-center text-ink/60">Buku tidak ditemukan. Coba kata kunci lain.</td></tr>
    @endforelse
    </tbody>
  </table>
</div>
<div class="mt-5">{{ $books->links() }}</div>
@endsection
