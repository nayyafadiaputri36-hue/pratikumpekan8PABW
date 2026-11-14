
<?php

use Illuminate\Support\Facades\Route;
use Modules\UserManagement\Http\Controllers\UserManagementController;

Route::middleware(['auth', 'can:access-admin'])
    ->prefix('users')
    ->group(function () {

        Route::get('/', [UserManagementController::class, 'index'])
            ->name('users.index');

        Route::post('/', [UserManagementController::class, 'store'])
            ->name('users.store');

        Route::put('/{id}', [UserManagementController::class, 'update'])
            ->name('users.update');

        Route::delete('/{id}', [UserManagementController::class, 'destroy'])
            ->name('users.destroy');
    });
