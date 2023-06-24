<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CollectorsController;
use App\Http\Controllers\APListController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpensesController;

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

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/employees',[EmployeesController::class, 'index'])->name('employees');
    Route::get('/employees/create',[EmployeesController::class, 'createView'])->name('create_view_employees');
    Route::post('/employees/create',[EmployeesController::class, 'create'])->name('create_post_employees');
    Route::put('/employee/resign',[EmployeesController::class, 'resign'])->name('resign_employee');
    Route::get('/employee/{id}',[EmployeesController::class, 'show'])->name('show_employee');
    Route::put('/employee/{id}',[EmployeesController::class, 'put'])->name('update_employee');


    Route::get('/collectors',[CollectorsController::class, 'index'])->name('collectors');
    Route::post('add-collector', [CollectorsController::class, 'addCollector'])->name('add-collector');
    Route::get('/collectors/{id}/{name}',[CollectorsController::class, 'viewCollector'])->name('collectors.show');
    Route::post('add-batch',[CollectorsController::class, 'saveBatch'])->name('add-batch');
    Route::get('/collectors/batch/{batch_id}/{name}',[CollectorsController::class, 'viewWithdrawals'])->name('collectors.withdrawals');

    Route::get('/ap_list',[APListController::class, 'index'])->name('ap_list');
    Route::post('add-aplist',[APListController::class, 'saveAPList'])->name('add-aplist');

    Route::get('/suppliers',[SupplierController::class, 'index'])->name('suppliers');
    Route::post('add-supplier', [SupplierController::class,'saveSupplier'])->name('add-supplier');

    Route::get('/products',[StockController::class, 'index'])->name('products');
    Route::post('add-product', [StockController::class, 'saveProduct'])->name('add-product');

    Route::get('/expenses',[ExpensesController::class, 'index'])->name('expenses');
    Route::post('add-expenses',[ExpensesController::class, 'saveExpenses'])->name('add-expenses');

});


Route::get('/', function () {
    return redirect('/login');
});
Route::view('/login1', 'login');
Route::view('/register1', 'register');



Auth::routes();
