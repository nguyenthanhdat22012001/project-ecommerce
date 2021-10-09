<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CouponController;

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

Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'authenticate']);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'get_user']);
    Route::post('profile/change-password', [UserController::class, 'change_password']);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('coupons', CouponController::class);
});
