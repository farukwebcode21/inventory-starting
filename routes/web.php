<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;
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
    return view('welcome');
});

Route::controller(UserController::class)->group(function () {
    Route::post('user-registation', 'User_Registation');
    Route::post('user-login', 'userLogin');
    Route::post('send-otp', 'sendOtpCode');
    Route::post('verify-otp', 'VerifyOTP');
    Route::post('reset-pass', 'resetPassword')->middleware([TokenVerification::class]);
});