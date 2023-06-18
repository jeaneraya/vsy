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

    Route::middleware(['isRoleSuperAdmin'])->group(function () {
        Route::get('/users', [AccountController::class, 'index'])->name('get_user_index');
        Route::post('/user', [AccountController::class, 'store']);
        Route::put('/user/{id}', [AccountController::class, 'put'])->name('put_user');
        Route::put('/user/{userId}/archive', [AccountController::class, 'archive_user'])->name('put_user_archive');


        Route::get('/user/create', [AccountController::class, 'createView'])->name('get_user_create');
        Route::post('/user/create', [AccountController::class, 'create'])->name('post_user_create');

        Route::get('/user/{userId}', [AccountController::class, 'get'])->name('get_user');

    });

    Route::middleware(['isRoleAdmin'])->group(function () {


    });

    Route::middleware(['isRoleCollector'])->group(function () {


    });

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('/employees',[App\Http\Controllers\EmployeesController::class, 'index'])->name('employees');

    Route::get('/collectors',[App\Http\Controllers\CollectorsController::class, 'index'])->name('collectors');
    Route::post('form-submit', [App\Http\Controllers\CollectorsController::class, 'addCollector'])->name('form-submit');


    Route::get('/ap_list',[App\Http\Controllers\APListController::class, 'index'])->name('ap_list');

    Route::get('/suppliers',[App\Http\Controllers\SupplierController::class, 'index'])->name('suppliers');

    Route::get('/stocks',[App\Http\Controllers\StockController::class, 'index'])->name('stocks');

    Route::get('/expenses',[App\Http\Controllers\ExpensesController::class, 'index'])->name('expenses');

});


Route::get('/', function () {
    return redirect('/login');
});
Route::view('/login1', 'login');
Route::view('/register1', 'register');



Auth::routes();
