<?php

namespace Modules\Peminjaman\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Peminjaman\Models\Peminjaman;
use Modules\Buku\Models\Book;

class PeminjamanController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $query = Peminjaman::with(['user', 'book'])->latest();

        if (Auth::user()->role !== 'admin') {
            $query->where('user_id', Auth::id());
        }

        $peminjamans = $query->paginate(10);
        $books = Book::where('stok', '>', 0)->orderBy('judul')->get();

        return view('peminjaman::index', compact(
            'peminjamans',
            'books'
        ));
    }

    // Menyimpan peminjaman melalui AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'tanggal_pinjam' => 'required|date',
        ]);

        try {
            $peminjaman = DB::transaction(function () use ($validated) {
                $book = Book::where('id', $validated['book_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($book->stok < 1) {
                    throw new \RuntimeException('Stok buku habis.');
                }

                $book->decrement('stok');

                return Peminjaman::create([
                    'user_id' => Auth::id(),
                    'book_id' => $book->id,
                    'tanggal_pinjam' => $validated['tanggal_pinjam'],
                    'status' => 'dipinjam',
                ]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Peminjaman berhasil dibuat!',
                'data' => $peminjaman->load(['user', 'book']),
            ]);
        } catch (\RuntimeException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

    // Mengembalikan buku
    public function returnBook($id)
    {
        $peminjaman = Peminjaman::with('book')->findOrFail($id);

        if (
            Auth::user()->role !== 'admin' &&
            $peminjaman->user_id !== Auth::id()
        ) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return response()->json([
                'success' => false,
                'message' => 'Buku sudah dikembalikan.',
            ], 422);
        }

        DB::transaction(function () use ($peminjaman) {
            $peminjaman->update([
                'status' => 'dikembalikan',
                'tanggal_kembali' => now()->toDateString(),
            ]);

            $peminjaman->book()->increment('stok');
        });

        return response()->json([
            'success' => true,
            'message' => 'Buku berhasil dikembalikan!',
        ]);
    }
}
