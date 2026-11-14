@extends('layouts.app')
@section('title', $user->exists ? 'Ubah Pengguna' : 'Tambah Pengguna')
@section('content')
<div class="max-w-xl">
  <h1 class="font-display text-3xl font-bold mb-6">{{ $user->exists ? 'Ubah pengguna' : 'Tambah pengguna' }}</h1>
  <form method="POST" action="{{ $user->exists ? route('users.update', $user) : route('users.store') }}" class="card p-6 grid gap-4">
    @csrf @if($user->exists) @method('PUT') @endif
    <div><label class="label">Nama</label><input name="name" value="{{ old('name', $user->name) }}" class="input">@error('name')<p class="err">{{ $message }}</p>@enderror</div>
    <div><label class="label">Email</label><input name="email" value="{{ old('email', $user->email) }}" class="input">@error('email')<p class="err">{{ $message }}</p>@enderror</div>
    <div>
      <label class="label">Role</label>
      <select name="role" class="input">
        @foreach(['user', 'admin'] as $r)<option value="{{ $r }}" @selected(old('role', $user->role) === $r)>{{ $r }}</option>@endforeach
      </select>
      @error('role')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="label">Kata sandi {{ $user->exists ? '(kosongkan jika tidak diganti)' : '' }}</label>
      <input name="password" type="password" class="input">@error('password')<p class="err">{{ $message }}</p>@enderror
    </div>
    <div class="flex gap-2 pt-2"><button class="btn-primary">Simpan pengguna</button><a href="{{ route('users.index') }}" class="btn-ghost">Batal</a></div>
  </form>
</div>
@endsection
