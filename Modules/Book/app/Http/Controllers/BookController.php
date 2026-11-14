<?php
namespace Modules\Book\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Book\Http\Requests\BookRequest;
use Modules\Book\Models\Book;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $books = Book::query()
            ->when($request->q, fn ($q, $s) => $q->where(fn ($w) => $w
                ->where('judul', 'like', "%$s%")->orWhere('penulis', 'like', "%$s%")->orWhere('penerbit', 'like', "%$s%")))
            ->latest()->paginate(5)->withQueryString();
        return view('book::index', compact('books'));
    }

    public function create() { return view('book::form', ['book' => new Book]); }

    public function store(BookRequest $request)
    {
        Book::create($request->validated());
        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Book $book) { return view('book::form', compact('book')); }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());
        return redirect()->route('books.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus.');
    }
}
