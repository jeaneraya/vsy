<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\CollectorsController;
use App\Http\Controllers\APListController;
use App\Http\Controllers\CronController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\PayrollComputationsController;
use App\Http\Controllers\PayrollScheduleController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\RemindersLoggerController;

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

    Route::get('/dashboard', [DashboardController::class, 'indexxx'])->name('dashboard');

    Route::middleware(['isRoleSuperAdmin'])->group(function () {
        Route::get('/users', [AccountController::class, 'index'])->name('get_user_index');
        Route::post('/user', [AccountController::class, 'store']);
        Route::put('/user/{id}', [AccountController::class, 'put'])->name('put_user');
        Route::put('/user/{userId}/archive', [AccountController::class, 'archive_user'])->name('put_user_archive');


        Route::get('/user/create', [AccountController::class, 'createView'])->name('get_user_create');
        Route::post('/user/create', [AccountController::class, 'create'])->name('post_user_create');

        Route::get('/user/{userId}', [AccountController::class, 'get'])->name('get_user');
        Route::put('/user/{userId}/info', [AccountController::class, 'update_details'])->name('update_details');
    });

    Route::middleware(['isRoleAdmin'])->group(function () {


    });

    Route::middleware(['isRoleCollector'])->group(function () {


    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // employees
    Route::get('/employees',[EmployeesController::class, 'index'])->name('employees');
    Route::get('/employees/create',[EmployeesController::class, 'createView'])->name('create_view_employees');
    Route::post('/employees/create',[EmployeesController::class, 'create'])->name('create_post_employees');
    Route::put('/employee/resign',[EmployeesController::class, 'resign'])->name('resign_employee');
    Route::get('/employee/{id}',[EmployeesController::class, 'show'])->name('show_employee');
    Route::put('/employee/{id}',[EmployeesController::class, 'put'])->name('update_employee');


    // reminders log
    Route::get('/reminder-logs',[RemindersLoggerController::class, 'view_reminders_log'])->name('view_reminders_log');

    // reminders
    Route::get('/reminders',[ReminderController::class, 'index'])->name('reminders');
    Route::get('/reminder/create',[ReminderController::class, 'view_add_reminder'])->name('view_add_reminder');
    Route::post('/reminder/create',[ReminderController::class, 'store'])->name('post_add_reminder');
    Route::get('/reminder/{id}',[ReminderController::class, 'show'])->name('show_reminder');
    Route::put('/reminder/{id}',[ReminderController::class, 'update'])->name('update_reminder');
    Route::put('/reminder/{id}/is_active',[ReminderController::class, 'is_active'])->name('put_reminder_is_active');



    // notifications
    Route::get('/notifications',[ReminderController::class, 'notifications_index'])->name('notifications_index');
    Route::put('/notifications',[ReminderController::class, 'update_is_read'])->name('update_is_read');


    // payroll computations
    Route::get('/payroll/schedule/computation',[PayrollComputationsController::class, 'index'])->name('payroll_computations');
    Route::put('/payroll/schedule/computation/{id}/claimed',[PayrollComputationsController::class, 'put_claimed'])->name('put_payroll_computation_claim');
    Route::get('/payroll/schedule/computation/{id}/employee/{employee_id}',[PayrollComputationsController::class, 'show_employee'])->name('payroll_computations_employee');
    Route::put('/payroll/schedule/computation/{id}/employee/{employee_id}',[PayrollComputationsController::class, 'update_employee'])->name('payroll_computations_employee_put');
    Route::get('/payroll/schedule/computation/{id}',[PayrollComputationsController::class, 'view_create'])->name('view_add_payroll_computations');
    Route::post('/payroll/schedule/computation/{id}',[PayrollComputationsController::class, 'create'])->name('create_add_payroll_computations');

    // payroll schedule
    Route::get('/payroll/schedule/{schedule_id}',[PayrollScheduleController::class, 'show'])->name('show_payroll_schedule');
    Route::put('/payroll/schedule/{schedule_id}',[PayrollScheduleController::class, 'update'])->name('put_payroll_schedule');
    Route::post('/payroll/schedule/add',[PayrollScheduleController::class, 'store'])->name('store_payroll_schedule');
    Route::get('/payroll/schedule',[PayrollScheduleController::class, 'index'])->name('payroll_schedule');

    //Collectors
    Route::get('/collectors',[CollectorsController::class, 'index'])->name('collectors');
    Route::get('collectors/in-active', [CollectorsController::class, 'collectorsInactive'])->name('collectors-inactive');
    Route::get('collectors/all', [CollectorsController::class, 'collectorsAll'])->name('collectors-all');
    Route::post('add-collector', [CollectorsController::class, 'addCollector'])->name('add-collector');
    Route::post('edit-collector', [CollectorsController::class, 'editCollector'])->name('edit-collector');
    Route::get('delete-collector/{id}', [CollectorsController::class, 'deleteCollector'])->name('delete-collector');
    Route::get('/collectors/{id}/{name}',[CollectorsController::class, 'viewCollector'])->name('collectors.show');
    Route::get('/collectors/{id}/{name}/in-active',[CollectorsController::class, 'viewCollectorInactive'])->name('collectors.show-inactive');
    Route::get('/collectors/{id}/{name}/all',[CollectorsController::class, 'viewCollectorAll'])->name('collectors.show-all');
    Route::post('add-batch',[CollectorsController::class, 'saveBatch'])->name('add-batch');
    Route::post('edit-batch', [CollectorsController::class, 'editBatch'])->name('edit-batch');
    Route::get('delete-batch/{collector_id}/{batch_id}/{name}', [CollectorsController::class, 'deleteBatch'])->name('delete-batch');
    Route::get('/collectors/{collector_id}/{batch_id}/{name}',[CollectorsController::class, 'viewWithdrawals'])->name('collectors.withdrawals');
    Route::get('productcode-autocomplete',[CollectorsController::class, 'searchProductCode'])->name('productcode-autocomplete');
    Route::get('expenses-autocomplete',[CollectorsController::class, 'searchExpensesCode'])->name('expenses-autocomplete');
    Route::get('/get-product',[CollectorsController::class, 'getProductPrice'])->name('get-product');
    Route::post('add-batch-product',[CollectorsController::class, 'saveBatchProduct'])->name('add-batch-product');
    Route::post('add-batch-expenses',[CollectorsController::class, 'saveBatchExpenses'])->name('add-batch-expenses');
    Route::get('add-payment',[CollectorsController::class, 'addPayment'])->name('add-payment');
    Route::get('payment-data/{id}',[CollectorsController::class, 'getEditPaymentData'])->name('payment-data');
    Route::get('edit-payment',[CollectorsController::class, 'editPayment'])->name('edit-payment');
    Route::delete('delete-payment',[CollectorsController::class, 'deletePayment'])->name('delete-payment');
    Route::get('stock-delivery/{user_id}/{name}',[CollectorsController::class, 'stockDelivery'])->name('stock-delivery');
    Route::post('add-stock-delivery',[CollectorsController::class, 'addStockDelivery'])->name('add-stock-delivery');
    Route::post('add-stock-payment',[CollectorsController::class, 'addStockPayment'])->name('add-stock-payment');
    Route::get('print-stock-delivery/{user_id}/{name}',[CollectorsController::class, 'printStockDelivery'])->name('print-stock-delivery');
    Route::get('print-expenses-summary/{collector_id}/{batch_id}/{name}',[CollectorsController::class, 'viewWithdrawals'])->name('print-expenses-summary');
    Route::get('credit-computation/{collector_id}/{batch_id}/{name}',[CollectorsController::class, 'viewWithdrawals'])->name('credit-computation');
    Route::get('trust-receipt/{collector_id}/{batch_id}/{name}',[CollectorsController::class, 'viewWithdrawals'])->name('trust-receipt');

    Route::get('/ap_list',[APListController::class, 'index'])->name('ap_list');
    Route::get('/ap_list/aplist-inactive', [APListController::class, 'aplistInactive'])->name('aplist-inactive');
    Route::get('/ap_list/aplist-all', [APListController::class, 'aplistAll'])->name('aplist-all');
    Route::post('add-aplist',[APListController::class, 'saveAPList'])->name('add-aplist');
    Route::post('edit-aplist',[APListController::class, 'editAPList'])->name('edit-aplist');
    Route::get('delete-aplist/{id}',[APListController::class, 'deleteAPList'])->name('delete-aplist');

    // Suppliers
    Route::get('/suppliers',[SupplierController::class, 'index'])->name('suppliers');
    Route::post('add-supplier', [SupplierController::class,'saveSupplier'])->name('add-supplier');
    Route::post('edit-supplier', [SupplierController::class, 'editSupplier'])->name('edit-supplier');
    Route::get('delete/{id}', [SupplierController::class, 'deleteSupplier'])->name('delete-supplier');

    Route::get('/products',[StockController::class, 'index'])->name('products');
    Route::get('/products/all',[StockController::class, 'showAll'])->name('show-all');
    Route::get('/products/inactive',[StockController::class, 'showInactive'])->name('show-inactive');
    Route::post('add-product', [StockController::class, 'saveProduct'])->name('add-product');
    Route::post('edit-product', [StockController::class, 'editProduct'])->name('edit-product');
    Route::get('delete-product/{id}', [StockController::class, 'deleteProduct'])->name('delete-product');

    Route::get('/expenses',[ExpensesController::class, 'index'])->name('expenses');
    Route::post('add-expenses',[ExpensesController::class, 'saveExpenses'])->name('add-expenses');
    Route::post('edit-expenses', [ExpensesController::class, 'editExpenses'])->name('edit-expenses');
    Route::get('delete-expense/{id}', [ExpensesController::class, 'deleteExpense'])->name('delete-expense');

});


Route::get('/', function () {
    return redirect('/login');
});
Route::view('/login1', 'login');
Route::view('/register1', 'register');

 Route::prefix('cron')->group(function () {
    // Route::get('/birthdays', [CronController::class, 'todayBirthday']);
    // Route::get('/firstCollection', [CronController::class, 'firstMonthlyCollection']);
    // Route::get('/secondCollection', [CronController::class, 'secondMonthlyCollection']);
    // Route::get('/customReminders', [CronController::class, 'customReminders']);



    Route::get('/scheduler', [CronController::class, 'cronScheduler']);
    Route::get('/runner', [CronController::class, 'cronRunner']);
});


Auth::routes();
