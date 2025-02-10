<?php

use App\Http\Controllers\CurrencyRateController;
use App\Http\Controllers\GameController;
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

    // -- Currency Rate --
    Route::get('/currency-rate/scrape', [CurrencyRateController::class, 'scrapeAndStore'])->name('currency-rate.scrape');
    Route::get('/currency-rate/rates', [CurrencyRateController::class, 'rates'])->name('currency-rate.rates');
    Route::resource('currency-rate', CurrencyRateController::class, ['as' => 'currency-rate']);

    // -- SCOREBOARD --
    Route::get('/games', [GameController::class, 'index'])->name('games.index');
    Route::get('/operator', [GameController::class, 'operator'])->name('games.operator');
    Route::post('/games', [GameController::class, 'store'])->name('games.store');
    Route::post('/games/{game}/update-score', [GameController::class, 'updateScore'])->name('games.update-score');

    Route::post('/broadcasting/auth', function () {
        return response()->json(['message' => 'authenticated']);
    })->middleware(['web']);
});

require __DIR__ . '/auth.php';
