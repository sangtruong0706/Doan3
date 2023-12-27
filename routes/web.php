<?php

use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\StatisticalController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\SendMailController;

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/search-products', [HomeController::class, 'search'])->name('search.products');

Route::get('/products/{category_id}', [ClientProductController::class, 'index'])->name('client.product.index');
// Route::get('/client/products/filter/{categoryId}', [ClientProductController::class, 'filterByPrice'])->name('client.products.filter');
Route::post('/filter-products/{category}', [ClientProductController::class, 'filterProducts'])->name('filter.products');

Route::get('/products-detail/{id}', [ClientProductController::class, 'show'])->name('client.product.show');

// Route::middleware('auth')->group(function(){
Route::get('/show-cart', [HomeController::class, 'showCart'])->name('show.cart');
Route::post('/add-cart', [HomeController::class, 'addCart'])->name('add.cart');
Route::post('/update-cart', [HomeController::class, 'updateCart']);
// });
Route::post('/apply-coupon', [CartController::class, 'applyCoupon'])->name('apply.coupon');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/handle-checkout', [CartController::class, 'handleCheckout'])->name('handle.checkout');
Route::get('/thankyou', [CartController::class, 'thankyou'])->name('thankyou');
Route::get('/list-order', [OrderController::class, 'index'])->name('client.order.index');
Route::post('/cancel-order/{id}', [OrderController::class, 'cancel'])->name('client.order.cancel');

Auth::routes();
// Route::get('/dashboard', function () {
//     return view('admin.dashboard.index');})->name('dashboard');
Route::get('/dashboard', [StatisticalController::class, 'dashboard'])->name('dashboard');

Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('category', CategoryController::class);
Route::resource('product', ProductController::class);
Route::resource('coupon', CouponController::class);

Route::post('/send-mail', [SendMailController::class, 'SendMail'])->name('send.mail');
Route::post('/verifyotp', [HomeController::class, 'userActivation'])->name('verifyotp');
Route::get('/verifyaccount', [HomeController::class, 'verifyAccount'])->name('verifyaccount');

Route::get('/get-order', [AdminOrderController::class, 'index'])->name('admin.order.index');
Route::post('/update-status/{id}', [AdminOrderController::class, 'updateStatus'])->name('admin.order.update_status');
Route::delete('admin/order/delete/{id}', [AdminOrderController::class, 'delete'])->name('admin.order.delete');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

