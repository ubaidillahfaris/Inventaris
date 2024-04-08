<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiMasukController;
use App\Models\TransaksiMasuk;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')
->group(function(){
    
    Route::prefix('produk')
    ->name('produk.')
    ->controller(ProdukController::class)
    ->group(function(){
        Route::post('create','createProduk')->name('create');
    });

    Route::prefix('transaksi_masuk')
    ->name('transaksi_masuk.')
    ->controller(TransaksiMasukController::class)
    ->group(function(){
        Route::post('create','createTransaksi')->name('create');
    });

});




require __DIR__.'/auth.php';
