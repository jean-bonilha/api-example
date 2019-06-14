<?php

// public routes
Route::post('/login', 'Api\AuthController@login')->name('login');
Route::post('/register', 'Api\AuthController@register')->name('register');

// private routes
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'Api\AuthController@logout')->name('logout');
    Route::get('/auth/user', 'Api\AuthController@user')->name('user');
    Route::apiResources([
        'user' => 'UserController'
    ]);
});
