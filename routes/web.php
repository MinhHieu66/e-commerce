<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/admin/products', [ProductItemController::class, 'index'])->name('admin.products.index');
Route::delete('/admin/products/{id}', [ProductItemController::class, 'destroy'])->name('admin.products.destroy');
Route::get('/admin/products/create', [ProductItemController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductItemController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [ProductItemController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [ProductItemController::class, 'update'])->name('admin.products.update');

Route::get('/product/{id}', [ProductItemController::class, 'detail'])->name('product.detail');

Route::get('/products/sort', [ProductItemController::class, 'sortProducts'])->name('products.sortProducts');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/success', [CartController::class, 'checkoutSuccess'])->name('cart.success');
Route::resource('cart', CartController::class);

Route::get('/get-districts/{province_id}', [LocationController::class, 'getDistricts']);
Route::get('/get-wards/{district_id}', [LocationController::class, 'getWards']);

Route::post('/payment/momo', [PaymentController::class, 'payWithMomo'])->name('payment.momo');
Route::post('/payment/paypal', [PaymentController::class, 'payWithPaypal'])->name('payment.paypal');

Route::get('/payment/result', [PaymentController::class, 'result']);
