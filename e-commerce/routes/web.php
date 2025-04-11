<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/admin', [PageController::class, 'admin'])->name('admin');
Route::get('/admin/coupon', [PageController::class, 'coupon'])->name("admin.coupon");
Route::get('/admin/couponlist', [PromotionController::class, 'listPromotion'])->name('admin.couponlist');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::resource('cart', CartController::class);
