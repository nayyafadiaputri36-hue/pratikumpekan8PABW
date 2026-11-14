<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('loans', function (Blueprint $t) {
            $t->id();
            $t->string('nama_peminjam');
            $t->string('judul_buku');
            $t->date('tanggal_pinjam');
            $t->date('tanggal_kembali');
            $t->enum('status', ['Dipinjam', 'Dikembalikan'])->default('Dipinjam');
            $t->string('path')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('loans'); }
};
