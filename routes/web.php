<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::middleware(['auth'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');

    Route::get('/users', [AccountController::class, 'index']);
    Route::post('/user', [AccountController::class, 'store']);

    Route::get('/user/create', [AccountController::class, 'createView'])->name('get_user_create');
    Route::post('/user/create', [AccountController::class, 'create'])->name('post_user_create');
});


Route::get('/', function () {
    return redirect('/login');
});
Route::view('/login1', 'login');
Route::view('/register1', 'register');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
