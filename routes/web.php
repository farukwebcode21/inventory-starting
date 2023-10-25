<?php

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
    Route::post('userRegistration', 'User_Registation');
    Route::post('userLogin', 'userLogin');
    Route::post('sendOtp', 'sendOtpCode');
    Route::post('verifyOtp', 'VerifyOTP');
    Route::post('resetPassword', 'resetPassword')->middleware([TokenVerification::class]);
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'homePage');
});

// Route::get('logout', [UserController::class, 'UserLogout']);

// Route::get('userProfile', [UserController::class, 'ProfilePage']);

// Route::get('dashboard', [DashboardController::class, 'DashboardPage']);

// Route::get('categoryPage', [CategoryController::class, 'CategoryPage']);
// Route::get('customerPage', [CustomerController::class, 'CustomerPage']);
// Route::get('productPage', [ProductController::class, 'ProductPage']);

// Route::get('invoicePage', [InvoiceController::class, 'InvoicePage']);
// Route::get('salePage', [InvoiceController::class, 'SalePage']);
// Route::get('reportPage', [ReportController::class, 'ReportPage']);
