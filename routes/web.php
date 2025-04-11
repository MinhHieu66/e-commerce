<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);

Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/success', [CartController::class, 'checkoutSuccess'])->name('cart.success');
Route::resource('cart', CartController::class);

Route::get('/get-districts/{province_id}', [LocationController::class, 'getDistricts']);
Route::get('/get-wards/{district_id}', [LocationController::class, 'getWards']);
