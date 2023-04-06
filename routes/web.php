<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Dashboard\AdminDashboardController;
use App\Http\Controllers\Management\UserController;
use App\Http\Controllers\Management\RoleController;
use App\Http\Controllers\Management\PermissionController;
use App\Http\Controllers\Management\AccountTypeController;
use App\Http\Controllers\Management\BankController;
use App\Http\Controllers\Management\CategoryGroupController;
use App\Http\Controllers\Management\CategoryController;
use App\Http\Controllers\Management\BudgetController;
use App\Http\Controllers\Management\TransactionController;

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

Route::get('/',[HomeController::class,'index'])->name('/');
Route::post('user/authentication',[LoginController::class,'authentication'])->name('authentication');

Route::group(['middleware'=>'auth'],function(){

Route::get('user/logout',[LoginController::class,'logout'])->name('logout');

Route::get('dashboard',[AdminDashboardController::class,'index'])->name('dashboard');
Route::get('column/chart/data',[AdminDashboardController::class,'columChart'])->name('admin.column.chart');
Route::get('transactions',[TransactionController::class,'index'])->name('transactions');
Route::get('budgets',[BudgetController::class,'index'])->name('budgets');
Route::get('goals',[TransactionController::class,'goals'])->name('goals');
Route::get('application/users',[UserController::class,'appUsers'])->name('app.users');


  #########  Management ########
Route::post('user/update',[UserController::class,'updateUser'])->name('user.update');
Route::post('user/status',[UserController::class,'changeUserStatus'])->name('user.status');
Route::post('role/permissions',[RoleController::class,'rolePermissions'])->name('roles.permission');
Route::post('account/type/update',[AccountTypeController::class,'update'])->name('account_type.update');
Route::post('bank/update',[BankController::class,'update'])->name('bank.update');
Route::post('category/group/update',[CategoryGroupController::class,'update'])->name('category.group.update');
Route::post('category/update',[CategoryController::class,'update'])->name('update.catgeory');

###### Report #######
Route::get('users/report',[UserController::class,'generateReport'])->name('user.report');
Route::get('budget/reports',[BudgetController::class,'generateReport'])->name('budget.reports');
Route::get('transaction/reports',[TransactionController::class,'generateReport'])->name('transaction.reports');

Route::resources([
    'users'          =>UserController::class,
    'roles'          =>RoleController::class,
    'permissions'    =>PermissionController::class,
    'account_types'  =>AccountTypeController::class,
    'banks'          =>BankController::class,
    'category/group' =>CategoryGroupController::class,
    'category'       =>CategoryController::class,
   ]);
 });