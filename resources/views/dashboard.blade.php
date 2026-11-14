@extends('layouts.app')
@section('title', 'Ringkasan')
@section('content')
<h1 class="font-display text-3xl font-bold">Halo, {{ auth()->user()->name }}</h1>
<p class="text-ink/60 mt-1 mb-8">Kondisi perpustakaan hari ini.</p>
<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-8">
  @foreach([['Judul buku', $totalBuku], ['Total stok', $totalStok], ['Sedang dipinjam', $dipinjam], ['Sudah kembali', $kembali]] as [$l, $v])
    <div class="card p-5"><p class="text-sm text-ink/60">{{ $l }}</p><p class="font-display text-4xl font-bold mt-1">{{ $v }}</p></div>
  @endforeach
</div>
<div class="card">
  <div class="p-4 border-b border-line font-semibold">Peminjaman terbaru</div>
  @foreach($terbaru as $l)
    <div class="p-4 flex justify-between border-b border-line last:border-0 text-sm">
      <span><b>{{ $l->nama_peminjam }}</b> meminjam {{ $l->judul_buku }}</span>
      <span class="badge {{ $l->status === 'Dipinjam' ? 'bg-amber/25 text-amber-900' : 'bg-emerald-100 text-emerald-800' }}">{{ $l->status }}</span>
    </div>
  @endforeach
</div>
@endsection
