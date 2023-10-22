<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\RoleController;


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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('admin.dashboard.index');
})->name('dashboard');
Route::get('/home', function () {
    return view('client.layouts.app');
});

Auth::routes();
Route::resource('roles', RoleController::class);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
