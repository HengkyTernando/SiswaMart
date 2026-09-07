<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Penjual\DashboardController as PenjualDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// ─── Halaman Publik ───────────────────────────────────────────────────────────
Route::get('/', [\App\Http\Controllers\Public\HomeController::class, 'index'])->name('public.home');

Route::get('/kategori', [\App\Http\Controllers\Public\KategoriController::class, 'index'])->name('public.kategori.index');
Route::get('/kategori/{kategori:slug}', [\App\Http\Controllers\Public\KategoriController::class, 'show'])->name('public.kategori.show');

Route::get('/produk', [\App\Http\Controllers\Public\ProdukController::class, 'index'])->name('public.produk.index');
Route::get('/produk/{produk:slug}', [\App\Http\Controllers\Public\ProdukController::class, 'show'])->name('public.produk.show');

Route::view('/cara-pemesanan', 'public.cara-pemesanan')->name('public.cara_pemesanan');

// Submit ulasan dengan throttle (3 request / 1 menit)
Route::post('/produk/{produk:slug}/ulasan', [\App\Http\Controllers\Public\UlasanController::class, 'store'])
    ->name('public.ulasan.store')
    ->middleware('throttle:3,1');

// ─── Admin Area ───────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Manajemen Penjual
    Route::resource('penjual', \App\Http\Controllers\Admin\PenjualController::class)
        ->parameters(['penjual' => 'penjual']);
    Route::patch('penjual/{penjual}/toggle-status', [\App\Http\Controllers\Admin\PenjualController::class, 'toggleStatus'])
        ->name('penjual.toggleStatus');

    // Moderasi Produk
    Route::get('produk', [\App\Http\Controllers\Admin\ProdukController::class, 'index'])->name('produk.index');
    Route::get('produk/{produk}', [\App\Http\Controllers\Admin\ProdukController::class, 'show'])->name('produk.show');
    Route::patch('produk/{produk}/update-status', [\App\Http\Controllers\Admin\ProdukController::class, 'updateStatus'])->name('produk.updateStatus');
    Route::delete('produk/{produk}', [\App\Http\Controllers\Admin\ProdukController::class, 'destroy'])->name('produk.destroy');

    // Moderasi Ulasan
    Route::get('ulasan', [\App\Http\Controllers\Admin\UlasanController::class, 'index'])->name('ulasan.index');
    Route::patch('ulasan/{ulasan}/approve', [\App\Http\Controllers\Admin\UlasanController::class, 'approve'])->name('ulasan.approve');
    Route::patch('ulasan/{ulasan}/reject', [\App\Http\Controllers\Admin\UlasanController::class, 'reject'])->name('ulasan.reject');
});

// ─── Penjual Area ─────────────────────────────────────────────────────────────
Route::prefix('penjual')->name('penjual.')->middleware(['auth', 'penjual'])->group(function () {
    Route::get('/dashboard', [PenjualDashboardController::class, 'index'])->name('dashboard');
    Route::get('/laporan', [\App\Http\Controllers\Penjual\LaporanController::class, 'index'])->name('laporan');

    // Manajemen Produk
    Route::resource('produk', \App\Http\Controllers\Penjual\ProdukController::class)
        ->parameters(['produk' => 'produk']);
});

// ─── Profile (Breeze default, auth only) ─────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
