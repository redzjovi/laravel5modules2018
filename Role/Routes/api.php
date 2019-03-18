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
    Route::group(['middleware' => ['permission:api.v1.role.*']], function () {
        Route::resource('v1/role', 'Api\V1\RoleController', ['as' => 'api.v1'])->only(['index', 'store', 'show', 'update', 'destroy']);
    });
    Route::group(['middleware' => ['permission:api.v1.role.permission.*']], function () {
        Route::put('v1/role/permission/{role}')->name('api.v1.role.permission.update')->uses('Api\V1\Role\PermissionController@update');
    });
});
