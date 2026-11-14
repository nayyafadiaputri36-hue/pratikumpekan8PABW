@extends('layouts.app')
@section('title', 'Kelola Pengguna')
@section('content')
<div class="flex items-end justify-between mb-6">
  <div><h1 class="font-display text-3xl font-bold">Pengguna</h1><p class="text-ink/60 mt-1">Atur akun dan hak akses anggota.</p></div>
  <a href="{{ route('users.create') }}" class="btn-primary">Tambah pengguna</a>
</div>
<div class="card overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-left text-ink/60 border-b border-line"><tr><th class="p-4">Nama</th><th class="p-4">Email</th><th class="p-4">Role</th><th class="p-4 text-right">Aksi</th></tr></thead>
    <tbody>
    @foreach($users as $u)
      <tr class="border-b border-line last:border-0">
        <td class="p-4 font-semibold">{{ $u->name }} @if($u->id === auth()->id())<span class="text-ink/50 font-normal">(Anda)</span>@endif</td>
        <td class="p-4">{{ $u->email }}</td>
        <td class="p-4"><span class="badge {{ $u->role === 'admin' ? 'bg-amber/25 text-amber-900' : 'bg-slate-100 text-slate-700' }}">{{ $u->role }}</span></td>
        <td class="p-4 text-right whitespace-nowrap">
          <a href="{{ route('users.edit', $u) }}" class="text-spruce font-semibold hover:underline">Ubah</a>
          @if($u->id !== auth()->id())
          <form action="{{ route('users.destroy', $u) }}" method="POST" class="inline" onsubmit="return confirm('Hapus pengguna ini?')">
            @csrf @method('DELETE')<button class="ml-3 text-rose-600 font-semibold hover:underline">Hapus</button>
          </form>
          @endif
        </td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>
<div class="mt-5">{{ $users->links() }}</div>
@endsection
