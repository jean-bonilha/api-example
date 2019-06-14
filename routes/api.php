<?php

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

// App v1 API
Route::group([
    'middleware' => ['api.version:1'],
    'namespace' => 'Api',
    'prefix'     => 'v1',
], function ($router) {
    require base_path('routes/app_api.v1.php');
});
