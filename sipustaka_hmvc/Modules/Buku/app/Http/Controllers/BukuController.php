<?php

namespace Modules\Buku\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Buku\Models\Book;

class BukuController extends Controller
{
    // Menampilkan data buku
    public function index()
    {
        $books = Book::latest()->paginate(10);

        return view('buku::index', compact('books'));
    }

    // Menambahkan buku
    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
        ]);

        Book::create($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    // Mengubah data buku
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun_terbit' => 'required|digits:4',
            'kategori' => 'required|string|max:100',
            'stok' => 'required|integer|min:0',
        ]);

        $book = Book::findOrFail($id);
        $book->update($validated);

        return redirect()->route('buku.index')
            ->with('success', 'Data buku berhasil diperbarui!');
    }

    // Menghapus buku
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('buku.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
