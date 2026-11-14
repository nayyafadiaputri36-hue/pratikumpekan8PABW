@extends('layouts.app')
@section('title', $book->exists ? 'Ubah Buku' : 'Tambah Buku')
@section('content')
<div class="max-w-2xl">
  <h1 class="font-display text-3xl font-bold mb-6">{{ $book->exists ? 'Ubah data buku' : 'Tambah buku baru' }}</h1>
  <form method="POST" action="{{ $book->exists ? route('books.update', $book) : route('books.store') }}" class="card p-6 grid gap-4 sm:grid-cols-2">
    @csrf @if($book->exists) @method('PUT') @endif
    @foreach(['judul' => 'Judul', 'penulis' => 'Penulis', 'penerbit' => 'Penerbit'] as $f => $l)
      <div class="sm:col-span-2">
        <label class="label">{{ $l }}</label>
        <input name="{{ $f }}" value="{{ old($f, $book->$f) }}" class="input @error($f) border-rose-400 @enderror">
        @error($f)<p class="err">{{ $message }}</p>@enderror
      </div>
    @endforeach
    <div>
      <label class="label">Tahun terbit</label>
      <input name="tahun_terbit" type="number" value="{{ old('tahun_terbit', $book->tahun_terbit) }}" class="input @error('tahun_terbit') border-rose-400 @enderror">
      @error('tahun_terbit')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="label">Stok</label>
      <input name="stok" type="number" value="{{ old('stok', $book->stok) }}" class="input @error('stok') border-rose-400 @enderror">
      @error('stok')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div class="sm:col-span-2 flex gap-2 pt-2">
      <button class="btn-primary">Simpan buku</button>
      <a href="{{ route('books.index') }}" class="btn-ghost">Batal</a>
    </div>
  </form>
</div>
@endsection
