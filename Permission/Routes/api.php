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

Route::group(['middleware' => ['auth:api']], function () {
    Route::group(['middleware' => ['permission:api.v1.permission.*']], function () {
        Route::resource('v1/permission', 'Api\V1\PermissionController', ['as' => 'api.v1'])->only(['index', 'store', 'show', 'update', 'destroy']);
    });
});
