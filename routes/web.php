<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Modules\Book\Models\Book;
use Modules\Loan\Models\Loan;

Route::get('/', fn () => redirect()->route('dashboard'));

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => view('dashboard', [
        'totalBuku' => Book::count(),
        'totalStok' => Book::sum('stok'),
        'dipinjam' => Loan::where('status', 'Dipinjam')->count(),
        'kembali' => Loan::where('status', 'Dikembalikan')->count(),
        'terbaru' => Loan::latest()->take(5)->get(),
    ]))->name('dashboard');
});
