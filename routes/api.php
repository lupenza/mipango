<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\RegistrationController;
use App\Http\Controllers\Api\V1\LoanController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Api\V1\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::get('user',[HomeController::class,'user']);
Route::post('V1/payment',[PaymentController::class,'c2b_payment']);
Route::post('V1/payment-request',[PaymentController::class,'paymentRequest']);
Route::post('V1/member-registration',[RegistrationController::class,'memberRegistration']);
Route::post('V1/loan-application',[LoanController::class,'loanApplication']);
Route::post('V1/member-loans',[LoanController::class,'memberLoans']);


//Route::group(['middleware'=>'auth:sanctum','prefix'=>'V1'],function(){
Route::group(['prefix'=>'V1'],function(){
   // Route::post('member-registration',[RegistrationController::class,'memberRegistration']);
    Route::post('set-password',[RegistrationController::class,'setPassword']);
    Route::get('guarantor',[LoanController::class,'getGuarantor']);
   // Route::post('loan-application',[LoanController::class,'loanApplication']);
    Route::post('loan-approve',[LoanController::class,'loanApprove']);
    Route::post('homepage',[HomeController::class,'index']);
    Route::post('loans-to-attend',[LoanController::class,'loansToAttend']);
   // Route::post('member-loans',[LoanController::class,'memberLoans']);
});



