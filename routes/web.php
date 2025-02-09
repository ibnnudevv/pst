<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // -- POINT OF SALES --
    Route::get('/pos/detail-report/{kode_transaksi}', [ProdukController::class, 'detailReport'])->name('pos.detail-report');
    Route::get('/pos/report', [ProdukController::class, 'report'])->name('pos.report');
    Route::post('/pos/checkout', [ProdukController::class, 'checkout'])->name('pos.checkout');
    Route::get('/preview', [ProdukController::class, 'preview'])->name('pos.preview');
    Route::get('/dashboard', [ProdukController::class, 'index'])->name('dashboard');
    Route::resource('produk', ProdukController::class, ['as' => 'pos']);
});

require __DIR__ . '/auth.php';
