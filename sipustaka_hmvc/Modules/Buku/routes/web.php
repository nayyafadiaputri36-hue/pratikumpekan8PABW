<?php

use Illuminate\Support\Facades\Route;
use Modules\Buku\Http\Controllers\BukuController;

Route::middleware(['auth'])->prefix('buku')->group(function () {

    Route::get('/', [BukuController::class, 'index'])
        ->name('buku.index');

    Route::middleware('can:access-admin')->group(function () {

        Route::post('/', [BukuController::class, 'store'])
            ->name('buku.store');

        Route::put('/{id}', [BukuController::class, 'update'])
            ->name('buku.update');

        Route::delete('/{id}', [BukuController::class, 'destroy'])
            ->name('buku.destroy');
    });
});