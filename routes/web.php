<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\TokenVerifyMiddleware;

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
    return view('pages.landing-page');
});


// Front end Page route
Route::get('userLogin', [UserController::class, 'userLoginPage']);
Route::get('userRegister', [UserController::class, 'userRegisterPage']);
Route::get('sendOTP', [UserController::class, 'sendOTPPage']);
Route::get('verifyOTP', [UserController::class, 'verifyOTPPage']);
Route::get('passwordReset', [UserController::class, 'passwordResetPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/dashboard', [DashboardController::class, 'dashboardPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/profile', [UserController::class, 'profilePage'])->middleware([TokenVerifyMiddleware::class]);

Route::get('/category', [CategoryController::class, 'categoryPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/customer', [CustomerController::class, 'customerPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/product', [ProductController::class, 'productPage'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/salePage', [InvoiceController::class, 'salePageShow'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/invoicePage', [InvoiceController::class, 'invoicePageShow'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/reportPage', [ReportController::class, 'reportPageShow'])->middleware([TokenVerifyMiddleware::class]);



// Ajax API Route
Route::post('/user-register', [UserController::class, 'userRagistration']);
Route::post('/user-login', [UserController::class, 'userLoginAction']);
Route::post('/send-otp', [UserController::class, 'sendOTPCodeAction']);
Route::post('/verify-otp', [UserController::class, 'verifyOTPCodeAction']);
Route::post('/reset-password', [UserController::class, 'resetPasswordAction'])->middleware([TokenVerifyMiddleware::class]);

Route::get('/logout', [UserController::class, 'logoutAction']);

Route::get('/user-profile', [UserController::class, 'userProfileInfo'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/user-profile-update', [UserController::class, 'userProfileInfoUpdate'])->middleware([TokenVerifyMiddleware::class]);

// Category APIs
Route::get('/category-list', [CategoryController::class, 'categoryListShow'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-create', [CategoryController::class, 'categoryCreation'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-update', [CategoryController::class, 'categoryUpdating'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-delete', [CategoryController::class, 'categoryDeleting'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/category-by-id', [CategoryController::class, 'categoryById'])->middleware([TokenVerifyMiddleware::class]);

// Customer APIs
Route::get('/customer-list', [CustomerController::class, 'customerListShow'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-create', [CustomerController::class, 'customerCreation'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-update', [CustomerController::class, 'customerUpdating'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-delete', [CustomerController::class, 'customerDeleting'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/customer-by-id', [CustomerController::class, 'customerById'])->middleware([TokenVerifyMiddleware::class]);

// Product APIs
Route::get('/product-list', [ProductController::class, 'productListShow'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-create', [ProductController::class, 'productcreation'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-update', [ProductController::class, 'productUpdating'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-delete', [ProductController::class, 'productDeleting'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/product-by-id', [ProductController::class, 'productByID'])->middleware([TokenVerifyMiddleware::class]);

// Ivvoice APIs
Route::get('/invoice-list', [InvoiceController::class, 'invoiceListShow'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-create', [InvoiceController::class, 'invoiceCreation'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-details', [InvoiceController::class, 'invoiceDetails'])->middleware([TokenVerifyMiddleware::class]);
Route::post('/invoice-delete', [InvoiceController::class, 'invoiceDeleting'])->middleware([TokenVerifyMiddleware::class]);

// Dashboard Summary
Route::get('/dashboard-summary', [DashboardController::class, 'dashboardSummaryShow'])->middleware([TokenVerifyMiddleware::class]);
Route::get('/sales-report/{FromDate}/{ToDate}', [ReportController::class, 'salesReportGenerating'])->middleware([TokenVerifyMiddleware::class]);


