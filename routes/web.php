<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
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

Route::controller(UserController::class)->group(function () {

    // Page Route
    Route::get('user-registration', 'RegistrationPage')->name('user-registation');
    Route::get('user-login', 'LoginPage')->name('user.login');
    Route::get('logout', 'UserLogout')->name('user.logout');
    Route::get('user-profile', 'profilePage')->name('user.profile');
    Route::get('send-otp', 'SendOtpPage')->name('user.otp');
    Route::get('verify-otp', 'VerifyOTPPage');
    Route::get('reset-password', 'ResetPasswordPage');

// Use registation-login-reset-pass-send-otp logout
    Route::post('user-registration', 'User_Registation');
    Route::post('user-login', 'userLogin');
    Route::post('send-otp', 'sendOtpCode');
    Route::post('verify-otp', 'VerifyOTP');
    Route::post('reset-password', 'resetPassword')->middleware([TokenVerification::class]);

});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'homePage');
});

// Route::get('logout', [UserController::class, 'UserLogout']);

Route::get('dashboard', [DashboardController::class, 'dashboard']);

// Route::get('userLogin', [UserController::class, 'LoginPage']);
// Route::get('logout', [UserController::class, 'UserLogout']);
// Route::get('userProfile', [UserController::class, 'profilePage']);
// Route::get('userRegistration', [UserController::class, 'RegistrationPage']);
// Route::get('sendOtp', [UserController::class, 'SendOtpPage']);
// Route::get('verifyOtp', [UserController::class, 'VerifyOTPPage']);
// Route::get('resetPassword', [UserController::class, 'ResetPasswordPage']);

Route::get('categoryPage', [CategoryController::class, 'CategoryPage']);
Route::get('customerPage', [CustomerController::class, 'CustomerPage']);
Route::get('productPage', [ProductController::class, 'ProductPage']);

Route::get('invoicePage', [InvoiceController::class, 'InvoicePage']);
Route::get('salePage', [InvoiceController::class, 'SalePage']);
Route::get('reportPage', [ReportController::class, 'ReportPage']);
