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


    Route::post('/login', 'Auth\LoginController@login');
    Route::group(['middleware' => 'auth:admin-api'], function () {
        //app versions
        Route::post('/update_app_version', 'VersionController@updateVersion');
        Route::get('/app_versions', 'VersionController@showVersion');

        //users
        Route::get('/users', 'Users\UserController@index');
        Route::get('/user/{id}', 'Users\UserController@show');

        //admin profile
        Route::get('/profile', 'Auth\ProfileController@profile');
        Route::post('/update_profile', 'Auth\ProfileController@updateProfile');
    });
