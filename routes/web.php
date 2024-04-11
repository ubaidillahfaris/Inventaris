<?php

use App\Http\Controllers\ProdukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StokOpnameController;
use App\Http\Controllers\TransaksiKeluarController;
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
        Route::get('show','show')->name('show');
        Route::get('show_overview','showOverview')->name('show_overview');
        Route::post('create','createTransaksi')->name('create');
    });

    Route::prefix('transaksi_keluar')
    ->name('transaksi_keluar.')
    ->controller(TransaksiKeluarController::class)
    ->group(function(){
        Route::post('create','create')->name('create');
    });

    Route::prefix('stok_opaname')
    ->name('stok_opname.')
    ->controller(StokOpnameController::class)
    ->group(function(){
        Route::post('create_opname_per_produk','createOpnamePerProduk')->name('createOpnamePerProduk');
        Route::post('create_opname_all_produk','createOpnameAllProduk')->name('createOpnameAllProduk');
    });

});




require __DIR__.'/auth.php';
