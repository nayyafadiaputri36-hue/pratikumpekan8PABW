<?php
use Illuminate\Support\Facades\Route;
use Modules\Loan\Http\Controllers\LoanController;

Route::middleware('auth')->prefix('loans')->name('loans.')->group(function () {
    Route::get('/', [LoanController::class, 'index'])->name('index');
    Route::get('/data', [LoanController::class, 'list'])->name('data');
    Route::post('/', [LoanController::class, 'store'])->name('store');
    Route::get('/{loan}', [LoanController::class, 'show'])->name('show');
    Route::put('/{loan}', [LoanController::class, 'update'])->name('update');
    Route::delete('/{loan}', [LoanController::class, 'destroy'])->name('destroy');
});
