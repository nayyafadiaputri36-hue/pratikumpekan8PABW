<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Modules\Book\Models\Book;
use Modules\Loan\Models\Loan;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Admin Pustaka', 'email' => 'admin@sipustaka.test', 'password' => Hash::make('password'), 'role' => 'admin']);
        User::create(['name' => 'Anggota Satu', 'email' => 'user@sipustaka.test', 'password' => Hash::make('password'), 'role' => 'user']);

        $books = [
            ['Laskar Pelangi', 'Andrea Hirata', 'Bentang Pustaka', 2005, 7],
            ['Bumi Manusia', 'Pramoedya Ananta Toer', 'Hasta Mitra', 1980, 4],
            ['Negeri 5 Menara', 'Ahmad Fuadi', 'Gramedia', 2009, 6],
            ['Cantik Itu Luka', 'Eka Kurniawan', 'Gramedia', 2002, 3],
            ['Pulang', 'Leila S. Chudori', 'KPG', 2012, 5],
            ['Filosofi Teras', 'Henry Manampiring', 'Kompas', 2018, 9],
        ];
        foreach ($books as [$j, $p, $pb, $th, $s]) {
            Book::create(['judul' => $j, 'penulis' => $p, 'penerbit' => $pb, 'tahun_terbit' => $th, 'stok' => $s]);
        }

        $loans = [
            ['Dewi Lestari', 'Laskar Pelangi', '2025-03-01', '2025-03-08', 'Dikembalikan'],
            ['Budi Santoso', 'Bumi Manusia', '2025-03-04', '2025-03-11', 'Dipinjam'],
            ['Sari Wulandari', 'Pulang', '2025-03-05', '2025-03-12', 'Dipinjam'],
            ['Rizky Pratama', 'Filosofi Teras', '2025-03-06', '2025-03-13', 'Dikembalikan'],
            ['Nadia Putri', 'Negeri 5 Menara', '2025-03-07', '2025-03-14', 'Dipinjam'],
        ];
        foreach ($loans as [$n, $b, $a, $k, $s]) {
            Loan::create(['nama_peminjam' => $n, 'judul_buku' => $b, 'tanggal_pinjam' => $a, 'tanggal_kembali' => $k, 'status' => $s]);
        }
    }
}
