<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\CmtRatingController;
use App\Http\Controllers\Api\MainProductController;
use App\Http\Controllers\Api\TopicsController;
use App\Http\Controllers\Api\PostsController;
use App\Http\Controllers\Api\PostCmtController;
use App\Http\Controllers\Admin\CategoryAdmin;


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
    

});
Route::apiResource('/admin/category',CategoryAdmin::class);
Route::get('search', [SearchController::class, 'search']);
Route::apiResource('comments', CmtRatingController::class);
Route::get('product/comments/{product_id}', [MainProductController::class, 'get_comment_by_product']);
Route::get('oderby/product', [MainProductController::class, 'get_product_by']);
Route::apiresource('topics',TopicsController::class);
Route::apiresource('posts',PostsController::class);
Route::apiresource('posts_comment',PostCmtController::class);
Route::apiResource('products', ProductController::class);
    Route::apiResource('coupons', CouponController::class);