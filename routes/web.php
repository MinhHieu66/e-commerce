<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromotionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home']);
Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/admin', [PageController::class, 'admin'])->name('admin');

Route::get('/admin/coupon', [PromotionController::class, 'listPromotion'])->name("admin.coupon");
Route::get('/admin/coupon/create_coupon', [PromotionController::class, 'createPromotion'])->name("coupon.create");
Route::post('/admin/coupon/create_coupon', [PromotionController::class, 'postPromotion'])->name("coupon.postPromotion");

Route::get('/admin/coupon/delete_coupon', [PromotionController::class, 'deletePromotion'])->name("coupon.deletePromotion");

Route::get('/admin/coupon/update_coupon', [PromotionController::class, 'updatePromotion'])->name("coupon.updatePromotion");
Route::post('/admin/promotion/update/{id}', [PromotionController::class, 'postUpdatePromotion'])->name("coupon.postUpdatePromotion");

Route::get('/admin/coupon/search', [PromotionController::class, 'searchPromotion'])->name('coupon.search');
Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::resource('cart', CartController::class);
