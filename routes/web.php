<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductItemController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
// <--- Dòng này cần được thêm vào để import CategoryController

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Các Routes hiện có của bạn
Route::get('/', [PageController::class, 'home'])->name('home');

Route::get('/admin/products', [ProductItemController::class, 'index'])->name('admin.products.index');
Route::delete('/admin/products/{id}', [ProductItemController::class, 'destroy'])->name('admin.products.destroy');
Route::get('/admin/products/create', [ProductItemController::class, 'create'])->name('admin.products.create');
Route::post('/admin/products', [ProductItemController::class, 'store'])->name('admin.products.store');
Route::get('/admin/products/{id}/edit', [ProductItemController::class, 'edit'])->name('admin.products.edit');
Route::put('/admin/products/{id}', [ProductItemController::class, 'update'])->name('admin.products.update');

Route::get('/product/{id}', [ProductItemController::class, 'detail'])->name('product.detail');

Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::get('/cart/success', [CartController::class, 'checkoutSuccess'])->name('cart.success');
Route::resource('cart', CartController::class);

Route::get('/get-districts/{province_id}', [LocationController::class, 'getDistricts']);
Route::get('/get-wards/{district_id}', [LocationController::class, 'getWards']);

Route::post('/payment/momo', [PaymentController::class, 'payWithMomo'])->name('payment.momo');
Route::post('/payment/paypal', [PaymentController::class, 'payWithPaypal'])->name('payment.paypal');

Route::get('/payment/result', [PaymentController::class, 'result']);

// CRUD Promotion
Route::get('/admin/coupon', [PromotionController::class, 'listPromotion'])->name("admin.coupon");
Route::get('/admin/coupon/create_coupon', [PromotionController::class, 'createPromotion'])->name("coupon.create");
Route::post('/admin/coupon/create_coupon', [PromotionController::class, 'postPromotion'])->name("coupon.postPromotion");

Route::get('/admin/coupon/delete_coupon', [PromotionController::class, 'deletePromotion'])->name("coupon.deletePromotion");

Route::get('/admin/coupon/update_coupon', [PromotionController::class, 'updatePromotion'])->name("coupon.updatePromotion");
Route::post('/admin/promotion/update/{id}', [PromotionController::class, 'postUpdatePromotion'])->name("coupon.postUpdatePromotion");

Route::get('/admin/coupon/search', [PromotionController::class, 'searchPromotion'])->name('coupon.search');

// THÊM CÁC ROUTES CHO DANH MỤC (CATEGORIES) VÀO ĐÂY
// Bạn có thể đặt nó ở bất cứ đâu trong file routes/web.php,
// nhưng thường đặt các route liên quan đến admin/dashboard gần nhau.
Route::resource('categories', CategoryController::class);

// Gợi ý: Để giữ các route quản trị có tổ chức hơn, bạn có thể nhóm chúng lại
// Ví dụ:
// Route::prefix('admin')->group(function () {
//     Route::resource('products', ProductItemController::class);
//     Route::resource('categories', CategoryController::class);
//     // Thêm các route quản trị khác ở đây
// });

//User
//Route::resource('user', UsersController::class); 
Route::get('/admin/user-list', [UsersController::class, 'index'])->name('user.user-list'); 
Route::post('/user/store', [UsersController::class, 'store'])->name('user.store');

Route::get('/user-list/edit/{id}', [UsersController::class, 'edit'])->name('user.edit');
// Route::post('/user-list/update/{id}', [UsersController::class, 'update'])->name('user.update');
Route::put('/user/{id}', [UsersController::class, 'update'])->name('user.update');

Route::delete('/user/{id}', [UsersController::class, 'destroy'])->name('user.destroy');
Route::get('/user-list/{id}', [UsersController::class, 'destroy'])->name('user.delete'); // Xóa qua link

Route::get('/user/info/{id}', [UsersController::class, 'show'])->name('user.info-user');

// Search
Route::get('/search', [SearchController::class, 'search'])->name('search');
