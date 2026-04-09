<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{product}', [HomeController::class, 'show'])->name('product.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('cart.destroy');

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InteractionController;

use App\Http\Controllers\UserDashboardController;

Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/cancel/{order}', [CheckoutController::class, 'cancel'])->name('checkout.cancel');

    Route::post('/product/{product}/review', [InteractionController::class, 'storeReview'])->name('interactions.review.store');
    Route::post('/product/{product}/wishlist', [InteractionController::class, 'toggleWishlist'])->name('interactions.wishlist.toggle');
    Route::delete('/wishlist/{wishlist}', [InteractionController::class, 'removeWishlist'])->name('interactions.wishlist.remove');
    Route::post('/ticket', [InteractionController::class, 'storeTicket'])->name('interactions.ticket.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\BrandController as AdminBrandController;
use App\Http\Controllers\Support\TicketController as SupportTicketController;

Route::middleware(['auth', 'verified', 'role:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->only(['index', 'store', 'destroy']);
    Route::resource('brands', AdminBrandController::class)->only(['index', 'store', 'destroy']);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('users', AdminUserController::class);
});

Route::middleware(['auth', 'verified', 'role:Support'])->prefix('support')->name('support.')->group(function () {
    Route::resource('tickets', SupportTicketController::class);
});
