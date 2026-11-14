<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', [AuthController::class, 'login'])->name('login');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login.process');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.process');

Route::middleware('auth')->group(function () {

    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])
        ->middleware('can:access-admin')
        ->name('admin.dashboard');

    Route::get('/user/dashboard', [AuthController::class, 'userDashboard'])
        ->name('user.dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');
});