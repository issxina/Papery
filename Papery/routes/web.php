<?php

use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderDetailsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;



//home page
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home/category/{slug}', [HomeController::class, 'category'])->name('home.category');
Route::get('/search', [HomeController::class, 'searchbook']);
Route::get('/live-search', [HomeController::class, 'liveSearch'])->name('live.search');

//Dashboard page
Route::get('/dashboard', [DashboardController::class, 'index']);

// Login / Logout
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard สำหรับแอดมิน
Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// เฉพาะ user ที่ล็อกอิน
Route::middleware('auth:web')->group(function () {
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    Route::get('/profile/history', [HomeController::class, 'history'])->name('profile.history');
});

//cart & checkout
Route::middleware('auth:web,admin')->group(function () {
    // cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::get('/cart/add/{bookId}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('cart.clear');

    // checkout 
    Route::post('/checkout/upload', [CheckoutController::class, 'uploadForm'])->name('checkout.uploadForm');
    Route::post('/checkout/uploadslip', [CheckoutController::class, 'uploadSlip'])->name('checkout.uploadSlip');
});


//staff crud
Route::get('/staff', [StaffController::class, 'index']);
Route::get('/staff/adding',  [StaffController::class, 'adding']);
Route::post('/staff',  [StaffController::class, 'create']);
Route::get('/staff/{id}',  [StaffController::class, 'edit']);
Route::put('/staff/{id}',  [StaffController::class, 'update']);
Route::delete('/staff/remove/{id}',  [StaffController::class, 'remove']);
Route::get('/staff/reset/{id}',  [StaffController::class, 'reset']);
Route::put('/staff/reset/{id}',  [StaffController::class, 'resetPassword']);

//users crud
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/adding',  [UserController::class, 'adding']);
Route::post('/user',  [UserController::class, 'create']);
Route::get('/user/{id}',  [UserController::class, 'edit']);
Route::put('/user/{id}',  [UserController::class, 'update']);
Route::delete('/user/remove/{id}',  [UserController::class, 'remove']);
Route::get('/user/reset/{id}',  [UserController::class, 'reset']);
Route::put('/user/reset/{id}',  [UserController::class, 'resetPassword']);


//category crud
Route::get('/category', [CategoryController::class, 'index']);
Route::get('/category/adding',  [CategoryController::class, 'adding']);
Route::post('/category',  [CategoryController::class, 'create']);
Route::get('/category/{id}',  [CategoryController::class, 'edit']);
Route::put('/category/{id}',  [CategoryController::class, 'update']);
Route::delete('/category/remove/{id}',  [CategoryController::class, 'remove']);

//book crud
Route::get('/book', [BookController::class, 'index']);
Route::get('/book/adding',  [BookController::class, 'adding']);
Route::post('/book',  [BookController::class, 'create']);
Route::get('/book/{id}',  [BookController::class, 'edit']);
Route::put('/book/{id}',  [BookController::class, 'update']);
Route::delete('/book/remove/{id}',  [BookController::class, 'remove']);

//order crud
Route::get('/order', [OrderController::class, 'index']);
Route::get('/order/adding',  [OrderController::class, 'adding']);
Route::post('/order',  [OrderController::class, 'create']);
Route::get('/order/{id}',  [OrderController::class, 'edit']);
Route::put('/order/{id}',  [OrderController::class, 'update']);
Route::delete('/order/remove/{id}',  [OrderController::class, 'remove']);


//orderdetails crud
Route::get('/orderdetails', [OrderDetailsController::class, 'index']);
Route::get('/orderdetails/adding',  [OrderDetailsController::class, 'adding']);
Route::post('/orderdetails',  [OrderDetailsController::class, 'create']);
Route::get('/orderdetails/{id}',  [OrderDetailsController::class, 'edit']);
Route::put('/orderdetails/{id}',  [OrderDetailsController::class, 'update']);
Route::delete('/orderdetails/remove/{id}',  [OrderDetailsController::class, 'remove']);

//payment crud
Route::get('/payment', [PaymentController::class, 'index']);
Route::get('/payment/adding',  [PaymentController::class, 'adding']);
Route::post('/payment',  [PaymentController::class, 'create']);
Route::get('/payment/{id}',  [PaymentController::class, 'edit']);
Route::put('/payment/{id}',  [PaymentController::class, 'update']);
Route::delete('/payment/remove/{id}',  [PaymentController::class, 'remove']);
