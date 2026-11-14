<?php
namespace Modules\Book\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['judul', 'penulis', 'penerbit', 'tahun_terbit', 'stok'];
}
