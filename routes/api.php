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

Route::group(['middleware' => ['json.response']], function () {

    // public routes
    Route::post('/login', 'Api\AuthController@login')->name('login');
    Route::post('/register', 'Api\AuthController@register')->name('register');

    // private routes
    Route::middleware('auth:api')->group(function () {
        Route::get('/logout', 'Api\AuthController@logout')->name('logout');
        Route::get('/user', 'Api\AuthController@user')->name('user');
    });

});
