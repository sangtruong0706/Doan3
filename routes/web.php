<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('client.home');
Route::get('/products/{category_id}', [ClientProductController::class, 'index'])->name('client.product.index');
// Route::get('/client/products/filter/{categoryId}', [ClientProductController::class, 'filterByPrice'])->name('client.products.filter');

Route::get('/products-detail/{id}', [ClientProductController::class, 'show'])->name('client.product.show');

// Route::middleware('auth')->group(function(){

// })
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');})->name('dashboard');


// Auth::routes();
Route::resource('roles', RoleController::class);
Route::resource('users', UserController::class);
Route::resource('category', CategoryController::class);
Route::resource('product', ProductController::class);
Route::resource('coupon', CouponController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
