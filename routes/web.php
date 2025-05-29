<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\SearchController;


Route::get('/', [PageController::class, 'home']);

Route::get('/shop', [PageController::class, 'shop'])->name('shop');
Route::get('/admin', [PageController::class, 'admin'])->name('admin');



Route::get('/product/{id}', [ProductController::class, 'detail'])->name('product.detail');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/success', [CartController::class, 'checkoutSuccess'])->name('cart.success');
Route::resource('cart', CartController::class);

Route::get('/get-districts/{province_id}', [LocationController::class, 'getDistricts']);
Route::get('/get-wards/{district_id}', [LocationController::class, 'getWards']);

//Payment
Route::post('/payment', [PaymentController::class, 'create'])->name("payment");
Route::get('/payment/result', [PaymentController::class, 'result']);

//User
Route::get('/user-list', [UsersController::class, 'index'])->name('user.user-list'); 
Route::post('/user/store', [UsersController::class, 'store'])->name('user.store'); 
Route::post('/user/update/{id}', [UsersController::class, 'update'])->name('user.update'); 
Route::put('user/{user}', [UsersController::class, 'update'])->name('user.update'); 
Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
Route::post('user', [UsersController::class, 'store'])->name('user.store'); 
//Route::resource('user', UsersController::class); 

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');