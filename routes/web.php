<?php

use App\Http\Controllers\Backend\Admin\AnggotaController;
use App\Http\Controllers\Backend\Admin\BukuController;
use App\Http\Controllers\Backend\Admin\DashboardController;
use App\Http\Controllers\Backend\Admin\DendaController;
use App\Http\Controllers\Backend\Admin\KlasifikasiController;
use App\Http\Controllers\Backend\Admin\LaporanController;
use App\Http\Controllers\Backend\Admin\PenerbitController;
use App\Http\Controllers\Backend\Admin\PengembalianController;
use App\Http\Controllers\Backend\Admin\TransaksiController;
use App\Http\Controllers\Backend\Anggota\DashboardController as AnggotaDashboardController;
use App\Http\Controllers\Backend\Anggota\MelihatTransaksiController;
use App\Http\Controllers\Backend\Auth\LoginController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

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
    return redirect('login');
});
Route::get('login', [LoginController::class, 'index']);
Route::post('post/login', [LoginController::class, 'postlogin']);
Route::get('logout', [LoginController::class, 'logout']);

Route::group(['middleware' => 'admin'], function () {
    Route::prefix('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        //Anggota
        Route::get('anggota', [AnggotaController::class, 'index'])->name('anggota');
        Route::get('anggota/{id}/edit', [AnggotaController::class, 'edit']);
        Route::post('anggota', [AnggotaController::class, 'store'])->name('anggota.store');
        Route::delete('anggota/{id}', [AnggotaController::class, 'delete']);

        //Buku
        Route::get('buku', [BukuController::class, 'index'])->name('buku');
        Route::post('buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('buku/{id}/edit', [BukuController::class, 'edit']);
        Route::delete('buku/{id}', [BukuController::class, 'delete']);
        Route::get('buku/{id}/show', [BukuController::class, 'show'])->name('buku.show');

        //Penerbit
        Route::get('penerbit', [PenerbitController::class, 'index'])->name('penerbit');
        Route::post('penerbit', [PenerbitController::class, 'store'])->name('penerbit.store');
        Route::get('penerbit/{id}/edit', [PenerbitController::class, 'edit']);
        Route::delete('penerbit/{id}', [PenerbitController::class, 'delete']);

        //klasifikasi
        Route::get('klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi');
        Route::post('klasifikasi', [KlasifikasiController::class, 'store'])->name('klasifikasi.store');
        Route::get('klasifikasi/{id}/edit', [KlasifikasiController::class, 'edit']);
        Route::delete('klasifikasi/{id}', [KlasifikasiController::class, 'delete']);

        //Transaksi Peminjaman
        Route::get('transaksi', [TransaksiController::class, 'index'])->name('transaksi');
        Route::post('transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
        Route::get('transaksi/{id}/edit', [TransaksiController::class, 'edit']);
        Route::delete('transaksi/{id}', [TransaksiController::class, 'delete']);



        //Transaksi Pengembalian
        Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian');
        Route::get('pengembalian/{id}/kembali', [PengembalianController::class, 'kembali']);


        //Denda
        Route::get('denda', [DendaController::class, 'index'])->name('denda');

        //Laporan
        Route::get('laporan', [LaporanController::class, 'index'])->name('laporan');
    });
});



Route::group(['middleware' => 'anggota'], function () {
    Route::prefix('anggota')->group(function () {
        Route::get('dashboard', [AnggotaDashboardController::class, 'index'])->name('dashboard.index');

        Route::get('t-peminjaman', [MelihatTransaksiController::class, 'tpeminjaman'])->name('transaksi.peminjaman');
        Route::get('t-denda', [MelihatTransaksiController::class, 'tdenda'])->name('transaksi.denda');
        Route::get('t-buku', [MelihatTransaksiController::class, 'tbuku'])->name('transaksi.buku');
    });
});
