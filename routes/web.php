<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return view('pages.auth.login');
});

// Route::get('/login', function () {
//     return view('pages.auth.login');
// });

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');
    //user
    Route::resource('user', UserController::class);
    //category
    Route::resource('category', \App\Http\Controllers\CategoryController::class);
    //product
    Route::resource('product', \App\Http\Controllers\ProductController::class);
});
