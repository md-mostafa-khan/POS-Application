<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\TokenVerification;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::post('/form-submit', function (Request $request) {
    $email = $request->input('email');

    if ($email) {
        return response()->json([
            "status" => "success",
            "message" => "Form submitted successfully.",
            "email" => $email,
        ]);
    } else {
        return response()->json([
            "status" => "failed",
            "message" => "Form submission failed.",
        ]);
    }
});


Route::get('/user-agent', function (Request $request) {

    $userAgent = $request->header('User-Agent');

    return response($userAgent );
});


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

Route::get('/userLogin', [UserController::class, 'LoginPage']);
Route::get('/userRegistration', [UserController::class, 'RegistrationPage']);
Route::get('/sendOtp', [UserController::class, 'SendOtpPage']);
Route::get('/verifyOtp', [UserController::class, 'VerifyOTPPage']);
Route::get('/resetPassword', [UserController::class, 'ResetPasswordPage'])->middleware([TokenVerification::class]);
Route::get('/dashboard', [DashboardController::class, 'DashboardPage'])->middleware([TokenVerification::class]);
Route::get('/userProfile', [UserController::class, 'ProfilePage'])->middleware([TokenVerification::class]);
Route::get('/',[HomeController::class,'HomePage']);

Route::post('/user-registration', [UserController::class, 'UserRegistration']);

Route::post('/user-login', [UserController::class, 'UserLogin']);

Route::post('/user-otp', [UserController::class, 'SentOTPCode']);

Route::post('/user-otp-verify', [UserController::class, 'VerifyOTPCode']);

Route::post('/user-reset-password', [UserController::class, 'ResetPassword'])->middleware([TokenVerification::class]);

Route::get('/user-logout', [UserController::class, 'UserLogout']);

Route::get('/user-profile', [UserController::class, 'UserProfile'])->middleware([TokenVerification::class]);

Route::post('/user-profile-update', [UserController::class, 'UserProfileUpdate'])->middleware([TokenVerification::class]);


Route::get('/categoryPage',[CategoryController::class,'CategoryPage'])->middleware([TokenVerification::class]);
Route::get('/customerPage',[CustomerController::class,'CustomerPage'])->middleware([TokenVerification::class]);
Route::get('/productPage',[ProductController::class,'ProductPage'])->middleware([TokenVerification::class]);
Route::get('/invoicePage',[InvoiceController::class,'InvoicePage'])->middleware([TokenVerification::class]);
Route::get('/salePage',[InvoiceController::class,'SalePage'])->middleware([TokenVerification::class]);
Route::get('/reportPage',[ReportController::class,'ReportPage'])->middleware([TokenVerification::class]);






// Category API
Route::post("/create-category",[CategoryController::class,'CategoryCreate'])->middleware([TokenVerification::class]);
Route::get("/list-category",[CategoryController::class,'CategoryList'])->middleware([TokenVerification::class]);
Route::post("/delete-category",[CategoryController::class,'CategoryDelete'])->middleware([TokenVerification::class]);
Route::post("/update-category",[CategoryController::class,'CategoryUpdate'])->middleware([TokenVerification::class]);
Route::post("/category-by-id",[CategoryController::class,'CategoryById'])->middleware([TokenVerification::class]);


// // Customer API
Route::post("/create-customer",[CustomerController::class,'CustomerCreate'])->middleware([TokenVerification::class]);
Route::get("/list-customer",[CustomerController::class,'CustomerList'])->middleware([TokenVerification::class]);
Route::post("/delete-customer",[CustomerController::class,'CustomerDelete'])->middleware([TokenVerification::class]);
Route::post("/update-customer",[CustomerController::class,'CustomerUpdate'])->middleware([TokenVerification::class]);
Route::post("/customer-by-id",[CustomerController::class,'CustomerById'])->middleware([TokenVerification::class]);


// Product API
Route::post("/create-product",[ProductController::class,'ProductCreate'])->middleware([TokenVerification::class]);
Route::post("/delete-product",[ProductController::class,'ProductDelete'])->middleware([TokenVerification::class]);
Route::post("/update-product",[ProductController::class,'ProductUpdate'])->middleware([TokenVerification::class]);
Route::get("/list-product",[ProductController::class,'ProductList'])->middleware([TokenVerification::class]);
Route::post("/product-by-id",[ProductController::class,'ProductByID'])->middleware([TokenVerification::class]);



// // Invoice
Route::post("/invoice-create",[InvoiceController::class,'invoiceCreate'])->middleware([TokenVerification::class]);
Route::get("/invoice-select",[InvoiceController::class,'invoiceSelect'])->middleware([TokenVerification::class]);
Route::post("/invoice-details",[InvoiceController::class,'InvoiceDetails'])->middleware([TokenVerification::class]);
Route::post("/invoice-delete",[InvoiceController::class,'invoiceDelete'])->middleware([TokenVerification::class]);


// // SUMMARY & Report
Route::get("/summary",[DashboardController::class,'Summary'])->middleware([TokenVerification::class]);
Route::get("/sales-report/{FormDate}/{ToDate}",[ReportController::class,'SalesReport'])->middleware([TokenVerification::class]);
