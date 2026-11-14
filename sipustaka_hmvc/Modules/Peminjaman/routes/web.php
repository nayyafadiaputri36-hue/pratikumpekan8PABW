
<?php

use Illuminate\Support\Facades\Route;
use Modules\Peminjaman\Http\Controllers\PeminjamanController;

Route::middleware(['auth'])
    ->prefix('peminjaman')
    ->group(function () {

        Route::get('/', [PeminjamanController::class, 'index'])
            ->name('peminjaman.index');

        Route::post('/', [PeminjamanController::class, 'store'])
            ->name('peminjaman.store');

        Route::post('/{id}/kembalikan', [
            PeminjamanController::class,
            'returnBook'
        ])->name('peminjaman.return');
    });
