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
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ThumbsUpPostController;
use App\Http\Controllers\Api\CollectionCouponController;
use App\Http\Controllers\Api\CollectionProductController;
use App\Http\Controllers\Api\CollectionStoreController;
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

// auth
Route::post('register', [UserController::class,'register']);
Route::post('login', [UserController::class,'authenticate']);
Route::post('loginGoogle', [UserController::class,'loginWithGoogle']);
Route::post('forgot-password', [UserController::class, 'forgot_password']);
Route::post('reset-password', [UserController::class, 'reset_password']);
Route::get('refresh-token', [UserController::class, 'refreshToken']);

Route::group(['middleware' => 'jwt.verify'], function () {
    //client
    Route::get('profile', [UserController::class, 'get_user']);
    Route::post('profile/change-password', [UserController::class, 'change_password']);
    //log out
    Route::get('logout', [UserController::class, 'logout']);
    Route::apiResource('brands', BrandController::class);
    Route::apiResource('stores', StoreController::class);

});
    //seller
    Route::apiResource('coupons', CouponController::class);

Route::apiResource('products', ProductController::class);

Route::get('search', [SearchController::class, 'search']);
// Route::post('products/update/{product_id}', [ProductController::class,'update_product']);

Route::get('product/comments/{product_id}', [MainProductController::class, 'get_comment_by_product']);
Route::get('product/topsale', [MainProductController::class, 'getTopSalesProduct']);
Route::get('product/getall', [MainProductController::class, 'getAllProduct']);
Route::get('coupon/{store_id}', [MainProductController::class, 'getCoupon']);
Route::get('product/topbuy', [MainProductController::class, 'getTopBuyProduct']);
Route::get('product/toprating', [MainProductController::class, 'getTopProductRating']);
Route::get('store/topfollow', [MainProductController::class, 'getTopStoreFollow']);
Route::get('oderby/product/{key}/{id}', [MainProductController::class, 'get_product_by']);
Route::get('product/detail/{slug}', [MainProductController::class, 'getProductBySlug']);
Route::get('product/category/{slug}', [MainProductController::class, 'getProductByCategorySlug']);
Route::get('product/store/{slug}', [MainProductController::class, 'getProductByStoreSlug']);
    //comment
Route::apiResource('comments', CmtRatingController::class);

/**************route post**************/

Route::get('posts', [PostsController::class,'index']);
Route::get('topposts', [PostsController::class,'getTop10PostComment']);
Route::get('posts/{slug}', [PostsController::class,'getPostBySlug']);
Route::post('posts', [PostsController::class,'store']);
Route::post('like-post', [ThumbsUpPostController::class,'thumbsUpPost']);
Route::post('remove-like-post', [ThumbsUpPostController::class,'removeThumbsUpPost']);
Route::get('check-user-like-post', [ThumbsUpPostController::class,'getUserThumsUp']);
Route::get('posts/thumb-up/{post_id}', [ThumbsUpPostController::class,'getThumsUpByPost']);
/**************route post**************/
// Route::apiresource('posts_comment',PostCmtController::class);
Route::get('posts_comment', [PostCmtController::class,'index']);
Route::get('posts_comment/{id}', [PostCmtController::class,'getCommentByPostId']);
Route::post('posts_comment', [PostCmtController::class,'store']);

//collection coupon
Route::post('collection-coupon', [CollectionCouponController::class,'store']);
Route::get('collection-coupon/user/{user_id}', [CollectionCouponController::class,'getCouponOfUser']);
Route::delete('collection-coupon/{id}', [CollectionCouponController::class,'destroy']);
//collection product
Route::post('collection-product', [CollectionProductController::class,'store']);
Route::get('collection-product/user/{user_id}', [CollectionProductController::class,'getProductUserFavorite']);
Route::delete('collection-product', [CollectionProductController::class,'destroy']);
Route::get('collection-product/user-favorite-product', [CollectionProductController::class,'checkUserFavoriteProduct']);
//collection store
Route::post('collection-store', [CollectionStoreController::class,'store']);
Route::get('collection-store/user/{user_id}', [CollectionStoreController::class,'getStoreUserFollow']);
Route::delete('collection-store', [CollectionStoreController::class,'destroy']);
Route::get('collection-store/user-follow-store', [CollectionStoreController::class,'checkUserFollowStore']);


//route admin
Route::post('/admin/login', [UserController::class,'loginAdmin']);

Route::group(['middleware' => ['jwt.verify','admin']], function () {
//    Route::apiResource('/admin/category',CategoryAdmin::class);
    //logout
    Route::get('/admin/logout', [UserController::class, 'logout']);

});
Route::apiResource('/admin/category',CategoryAdmin::class);
