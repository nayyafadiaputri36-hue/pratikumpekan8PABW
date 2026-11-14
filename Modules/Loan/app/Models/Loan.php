<?php
namespace Modules\Loan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Loan extends Model
{
    protected $fillable = ['nama_peminjam', 'judul_buku', 'tanggal_pinjam', 'tanggal_kembali', 'status', 'path'];
    protected $casts = ['tanggal_pinjam' => 'date:Y-m-d', 'tanggal_kembali' => 'date:Y-m-d'];
    protected $appends = ['file_url'];

    public function getFileUrlAttribute(): ?string
    {
        return $this->path ? Storage::url($this->path) : null;
    }
}
