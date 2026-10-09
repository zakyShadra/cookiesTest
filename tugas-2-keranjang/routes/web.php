<?php

use App\Http\Controllers\KeranjangController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/index');
Route::get('/index', [KeranjangController::class, 'index']);
Route::get('/keranjang', [KeranjangController::class, 'keranjang']);
Route::post('/keranjang/tambah/{barang}', [KeranjangController::class, 'tambah']);
Route::post('/keranjang/ubah/{barang}/{aksi}', [KeranjangController::class, 'ubah'])->whereIn('aksi', ['plus', 'minus']);
Route::post('/keranjang/hapus/{barang}', [KeranjangController::class, 'hapus']);
Route::post('/keranjang/kosongkan', [KeranjangController::class, 'kosongkan']);
