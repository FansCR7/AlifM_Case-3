<?php

use App\Http\Controllers\AuthController;
use App\Livewire\Products\Index as ProductIndex;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/barang')->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'createLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'createRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/barang', ProductIndex::class)->name('products.index');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
