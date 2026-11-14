@extends('layouts.app')
@section('title', 'Peminjaman')
@section('content')
<div class="flex flex-wrap items-end justify-between gap-4 mb-6">
  <div><h1 class="font-display text-3xl font-bold">Peminjaman</h1><p class="text-ink/60 mt-1">Semua perubahan tersimpan tanpa memuat ulang halaman.</p></div>
  <button id="btn-add" class="btn-primary">Catat peminjaman</button>
</div>

<div class="card overflow-x-auto">
  <table class="w-full text-sm">
    <thead class="text-left text-ink/60 border-b border-line"><tr>
      <th class="p-4">Peminjam</th><th class="p-4">Buku</th><th class="p-4">Pinjam</th><th class="p-4">Kembali</th><th class="p-4">Status</th><th class="p-4">Bukti</th><th class="p-4 text-right">Aksi</th>
    </tr></thead>
    <tbody id="rows"><tr><td colspan="7" class="p-10 text-center text-ink/60">Memuat data…</td></tr></tbody>
  </table>
</div>

<div id="modal" class="fixed inset-0 bg-ink/50 hidden items-center justify-center p-4 z-50">
  <form id="form" class="card w-full max-w-lg p-6 grid gap-3 max-h-[92vh] overflow-y-auto" enctype="multipart/form-data">
    <h2 id="modal-title" class="font-display text-2xl font-bold"></h2>
    <input type="hidden" id="loan-id">
    @foreach(['nama_peminjam' => ['Nama peminjam', 'text'], 'judul_buku' => ['Judul buku', 'text'], 'tanggal_pinjam' => ['Tanggal pinjam', 'date'], 'tanggal_kembali' => ['Tanggal kembali', 'date']] as $f => [$l, $t])
      <div><label class="label">{{ $l }}</label><input name="{{ $f }}" type="{{ $t }}" class="input"><p class="err" data-err="{{ $f }}"></p></div>
    @endforeach
    <div><label class="label">Status</label>
      <select name="status" class="input"><option>Dipinjam</option><option>Dikembalikan</option></select><p class="err" data-err="status"></p></div>
    <div><label class="label">Bukti peminjaman (JPG, PNG, PDF, maks. 2 MB)</label>
      <input name="bukti" type="file" accept=".jpg,.jpeg,.png,.pdf" class="input">
      <p id="current-file" class="text-xs text-ink/60 mt-1"></p><p class="err" data-err="bukti"></p></div>
    <div class="flex gap-2 pt-2"><button class="btn-primary" id="btn-save">Simpan</button><button type="button" id="btn-cancel" class="btn-ghost">Batal</button></div>
  </form>
</div>
@endsection

@push('scripts')
<script>
const base = "{{ url('loans') }}";
const csrf = document.querySelector('meta[name=csrf-token]').content;
const $ = (s) => document.querySelector(s);
const form = $('#form'), modal = $('#modal');
const esc = (s) => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));

function toast(msg) {
  const t = $('#toast'); t.textContent = msg; t.classList.remove('hidden');
  setTimeout(() => t.classList.add('hidden'), 2800);
}
function clearErrors() { document.querySelectorAll('[data-err]').forEach(e => e.textContent = ''); }

async function api(url, opts = {}) {
  const res = await fetch(url, { ...opts, headers: { 'X-CSRF-TOKEN': csrf, 'Accept': 'application/json', ...(opts.headers || {}) } });
  const body = await res.json().catch(() => ({}));
  return { res, body };
}

async function load() {
  const { body } = await api(base + '/data');
  $('#rows').innerHTML = body.length ? body.map(l => `
    <tr class="border-b border-line last:border-0">
      <td class="p-4 font-semibold">${esc(l.nama_peminjam)}</td>
      <td class="p-4">${esc(l.judul_buku)}</td>
      <td class="p-4">${esc(l.tanggal_pinjam)}</td>
      <td class="p-4">${esc(l.tanggal_kembali)}</td>
      <td class="p-4"><span class="badge ${l.status === 'Dipinjam' ? 'bg-amber/25 text-amber-900' : 'bg-emerald-100 text-emerald-800'}">${esc(l.status)}</span></td>
      <td class="p-4">${l.file_url ? `<a class="text-spruce font-semibold hover:underline" target="_blank" href="${esc(l.file_url)}">Buka berkas</a>` : '<span class="text-ink/40">-</span>'}</td>
      <td class="p-4 text-right whitespace-nowrap">
        <button class="text-spruce font-semibold hover:underline" onclick="edit(${l.id})">Ubah</button>
        <button class="ml-3 text-rose-600 font-semibold hover:underline" onclick="removeLoan(${l.id})">Hapus</button>
      </td></tr>`).join('')
    : '<tr><td colspan="7" class="p-10 text-center text-ink/60">Belum ada peminjaman. Catat yang pertama.</td></tr>';
}

function openModal(title) { $('#modal-title').textContent = title; modal.classList.replace('hidden', 'flex'); }
function closeModal() { modal.classList.replace('flex', 'hidden'); form.reset(); clearErrors(); $('#loan-id').value = ''; $('#current-file').textContent = ''; }

$('#btn-add').onclick = () => { closeModal(); openModal('Catat peminjaman'); };
$('#btn-cancel').onclick = closeModal;

window.edit = async (id) => {
  const { body } = await api(`${base}/${id}`);
  closeModal();
  ['nama_peminjam','judul_buku','tanggal_pinjam','tanggal_kembali','status'].forEach(k => form.elements[k].value = body[k] ?? '');
  $('#loan-id').value = id;
  $('#current-file').textContent = body.path ? 'Berkas saat ini akan diganti jika Anda memilih berkas baru.' : '';
  openModal('Ubah peminjaman');
};

window.removeLoan = async (id) => {
  if (!confirm('Hapus data peminjaman ini?')) return;
  const { body } = await api(`${base}/${id}`, { method: 'DELETE' });
  toast(body.message || 'Terhapus'); load();
};

form.onsubmit = async (e) => {
  e.preventDefault(); clearErrors();
  const id = $('#loan-id').value;
  const fd = new FormData(form);
  if (id) fd.append('_method', 'PUT');
  $('#btn-save').disabled = true;
  const { res, body } = await api(id ? `${base}/${id}` : base, { method: 'POST', body: fd });
  $('#btn-save').disabled = false;

  if (res.status === 422) {                       // error validasi tampil di bawah input
    Object.entries(body.errors).forEach(([k, v]) => { const el = document.querySelector(`[data-err="${k}"]`); if (el) el.textContent = v[0]; });
    return;
  }
  if (!res.ok) return toast('Terjadi kesalahan. Coba lagi.');
  closeModal(); toast(body.message); load();
};
load();
</script>
@endpush
