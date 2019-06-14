<?php

// public routes
Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register')->name('register');

// private routes
Route::middleware('auth:api')->group(function () {
    Route::get('/logout', 'AuthController@logout')->name('logout');
    Route::get('/auth/user', 'AuthController@user')->name('user');
    Route::apiResources([
        'user' => 'UserController'
    ]);
});
