<?php

use Illuminate\Http\Request;

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

Route::prefix('v1/')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', 'AuthController@register');
        // Route::post('login', 'AuthController@authenticate');
        Route::post('login', 'AuthController@login');

        Route::group(['middleware' => 'jwt.admin.self'], function () {
            Route::get('user', 'AuthController@user');
            Route::get('refresh', 'AuthController@refresh');
            Route::post('logout', 'AuthController@logout');
        });
    });

    Route::group(['middleware' => 'jwt.admin.self'], function () {
        // Users

        //Admin
        Route::group(['middleware' => 'jwt.admin'], function () {
            //
        });
    });
});
