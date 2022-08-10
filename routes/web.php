<?php

use App\Models\Order;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::get('/', [\App\Http\Controllers\Frontend\IndexController::class, 'index']);

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dang-nhap', [\App\Http\Controllers\Admin\AuthController::class, 'login'])->name('login');
    Route::post('/authenticate', [\App\Http\Controllers\Admin\AuthController::class, 'authenticate'])->name('admin.authenticate');
    Route::get('/forgot-password', [\App\Http\Controllers\Admin\AuthController::class, 'forgot'])->name('admin.forgot');
    Route::post('/link-reset-password', [\App\Http\Controllers\Admin\AuthController::class, 'sendLink'])->name('admin.sendLink');
    Route::get('/reset-password/{token}', function ($token) {
        return view('admin.auth.reset-password', ['token' => $token]);
    })->name('password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Admin\AuthController::class, 'reset'])->name('admin.reset');

});

Route::get('/dang-nhap', [\App\Http\Controllers\Frontend\AuthController::class, 'login'])->name('frontend.login');
Route::get('/dang-ky', [\App\Http\Controllers\Frontend\AuthController::class, 'viewRegister'])->name('frontend.view-register');
Route::post('/dang-ky', [\App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('frontend.register');
Route::post('/authenticate', [\App\Http\Controllers\Frontend\AuthController::class, 'authenticate'])->name('frontend.authenticate');

Route::get('/forgot-password', [\App\Http\Controllers\Frontend\AuthController::class, 'forgot'])->name('frontend.forgot');
Route::post('/link-reset-password', [\App\Http\Controllers\Frontend\AuthController::class, 'sendLink'])->name('frontend.sendLink');
Route::post('/reset-password', [\App\Http\Controllers\Frontend\AuthController::class, 'reset'])->name('frontend.reset');

Route::get('/reset-password/{token}', function ($token) {
    return view('frontend.auth.reset-password', ['token' => $token]);
})->name('frontend.password.reset');

Route::group(['middleware' => 'auth-customer:customer'], function () {
    Route::get('/logout', [\App\Http\Controllers\Frontend\AuthController::class, 'logout'])->name('frontend.logout');
    Route::get('/profile', [\App\Http\Controllers\Frontend\CustomerController::class, 'profile'])->name('profile');
    Route::put('/profile', [\App\Http\Controllers\Frontend\CustomerController::class, 'update'])->name('profile.update');
    Route::post('/order', [\App\Http\Controllers\Frontend\OrderController::class, 'order'])->name('order');
    Route::get('/order/detail/{order}', [\App\Http\Controllers\Frontend\OrderController::class, 'detail'])->name('order.detail');
    Route::patch('/change-password', [\App\Http\Controllers\Frontend\AuthController::class, 'changePassword'])->name('change-password');
    Route::get('/logout', function () {
        \Illuminate\Support\Facades\Auth::logout();
        return back();
    })->name('frontend.logout');

    Route::get('/payment/{id}', [\App\Http\Controllers\Frontend\OrderController::class, 'vnPayPayment']);
    Route::get('/return-vnpay/{id}', [\App\Http\Controllers\Frontend\OrderController::class, 'vnpayReturn']);
});



Route::get('/list-product', [\App\Http\Controllers\Frontend\ListProductController::class, 'index'])->name('list-product.index');
Route::get('/list-product/getMoreCategory/{idx}', [\App\Http\Controllers\Frontend\ListProductController::class, 'getMoreCategory'])->name('list-product.getMoreCategory');

Route::get('/product/detail/{slug}', [\App\Http\Controllers\Frontend\DetailController::class, 'detail'])->name('product.detail');
Route::get('/cart', [\App\Http\Controllers\Frontend\OrderController::class, 'cart'])->name('cart');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'role:Quản trị viên|Nhân viên']], function (){
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'logout'])->name('admin.logout');

    // users
    Route::resource('/users', \App\Http\Controllers\Admin\UserController::class)->middleware('role:Quản trị viên');
    Route::get('/customers', [\App\Http\Controllers\Admin\CustomerController::class, 'index'])->name('customers.index');

    Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);
    Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class);
    Route::resource('/sliders', \App\Http\Controllers\Admin\SliderController::class);
    Route::get('/orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/detail/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'detail'])->name('orders.detail');
    Route::post('/orders/update-status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus']);

//    Route::get('/report', [\App\Http\Controllers\Admin\DashboardController::class, 'report'])->name('report');
});

