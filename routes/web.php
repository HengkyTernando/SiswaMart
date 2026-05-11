<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\SellerOrderController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{product:slug}', [HomeController::class, 'show'])->name('products.show');

// ─── Auth Routes ──────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('auth.login');
    Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register'])->name('auth.register');
});

Route::post('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');
    Route::resource('categories', CategoryController::class)->except(['show']);
});

// ─── Seller Routes ────────────────────────────────────────────────────────────
Route::prefix('seller')->name('seller.')->middleware(['auth', 'is_seller'])->group(function () {
    Route::get('/dashboard', fn() => view('seller.dashboard'))->name('dashboard');
    Route::resource('products', ProductController::class)->except(['show']);

    // Seller Orders & Chat
    Route::get('/orders',                        [SellerOrderController::class, 'index'])->name('orders');
    Route::patch('/orders/{order}/status',       [SellerOrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/orders/{order}/chat',           [ChatController::class, 'show'])->name('chat.show');
    Route::post('/orders/{order}/chat',          [ChatController::class, 'store'])->name('chat.store');
    Route::get('/orders/{order}/messages',       [ChatController::class, 'fetch'])->name('chat.fetch');
});

// ─── Customer Routes ──────────────────────────────────────────────────────────
Route::prefix('customer')->name('customer.')->middleware('auth')->group(function () {
    Route::get('/dashboard', fn() => view('customer.dashboard'))->name('dashboard');
    Route::get('/orders',    [OrderController::class, 'index'])->name('orders');

    // Order actions
    Route::post('/orders/{order}/complete', [OrderController::class, 'complete'])->name('orders.complete');

    // Chat
    Route::get('/orders/{order}/chat',     [ChatController::class, 'show'])->name('chat.show');
    Route::post('/orders/{order}/chat',    [ChatController::class, 'store'])->name('chat.store');
    Route::get('/orders/{order}/messages', [ChatController::class, 'fetch'])->name('chat.fetch');

    // Cart
    Route::get('/cart',           [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add',      [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update',  [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear',  [CartController::class, 'clear'])->name('cart.clear');

    // Checkout
    Route::get('/checkout',                    [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout',                   [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success/{code}',     [CheckoutController::class, 'success'])->name('checkout.success');
});
