<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CartController::class, 'index']);
Route::post('/cart/add', [CartController::class, 'add'])->middleware(['auth', 'can:use-cart']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::get('/barang', [BarangController::class, 'index']);

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/keranjang', [KeranjangController::class, 'index']);

    Route::middleware('can:use-cart')->group(function () {
        Route::post('/keranjang/tambah/{product}', [KeranjangController::class, 'tambah']);
        Route::post('/keranjang/ubah/{product}/{aksi}', [KeranjangController::class, 'ubah'])->whereIn('aksi', ['plus', 'minus']);
        Route::post('/keranjang/hapus/{product}', [KeranjangController::class, 'hapus']);
    });

    Route::post('/checkout', [PesananController::class, 'checkout']);
    Route::get('/pesanan', [PesananController::class, 'index']);
    Route::get('/pesanan/{id}', [PesananController::class, 'show']);
});

Route::middleware(['auth', 'can:manage-roles'])->group(function () {
    Route::get('/admin/users', [RoleController::class, 'index'])->name('admin.users.index');
    Route::patch('/admin/users/{user}/role', [RoleController::class, 'update'])->name('admin.users.role.update');
});
