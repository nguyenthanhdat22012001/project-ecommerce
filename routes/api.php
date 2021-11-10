<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::post('loginGoogle', [UserController::class,'loginWithGoogle']);
Route::post('forgot-password', [UserController::class, 'forgot_password']);
Route::post('reset-password', [UserController::class, 'reset_password']);
Route::get('refresh-token', [UserController::class, 'refreshToken']);
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::get('profile', [UserController::class, 'get_user']);
    Route::post('profile/change-password', [UserController::class, 'change_password']);
});
