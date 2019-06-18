<?php

// public routes
Route::post('/auth/login', 'AuthController@login')->name('login');
Route::post('/auth/register', 'AuthController@register')->name('register');

// private routes
Route::middleware('auth:api')->group(function () {
    Route::get('/auth/logout', 'AuthController@logout')->name('logout');
    Route::get('/auth/user', 'AuthController@user')->name('user');
    Route::apiResources([
        'user' => 'UserController',
        'company' => 'CompanyController',
        'person' => 'PersonController',
    ]);
});
