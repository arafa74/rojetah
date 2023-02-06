<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1/user'], function () {
    Route::post('/register', 'Auth\RegisterController@register');
    Route::post('/login', 'Auth\LoginController@login');
    Route::post('/social_login', 'Auth\LoginController@social_login');
    Route::get('/app_versions', 'VersionController@versions');
    Route::post('/get_otp_code', 'Auth\UserController@getOtpCode');
    Route::post('/verify_mobile_num', 'Auth\UserController@verifyPhone');
    Route::post('/reset_password', 'Auth\UserController@resetPassword');

    Route::group(['middleware' => ['auth:user-api']], function () {
        //User Profile
        Route::get('/profile', 'Auth\UserController@profile');
        Route::post('/change_password', 'Auth\UserController@changePassword');
    });
});
