<?php

use Modules\Authentication\Http\Middleware\Backend\V1\AuthenticationMiddleware;

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => [AuthenticationMiddleware::class]], function() {
        Route::resource('modules/permission/backend/v1/permission', '\Modules\Permission\Http\Controllers\Backend\V1\PermissionController', ['as' => 'modules.permission.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/permission/backend/v1/permission/action', ['as' => 'modules.permission.backend.v1.permission.action', 'uses' => '\Modules\Permission\Http\Controllers\Backend\V1\PermissionController@action']);
        Route::get('modules/permission/backend/v1/permission/{permission}/delete', ['as' => 'modules.permission.backend.v1.permission.delete', 'uses' => '\Modules\Permission\Http\Controllers\Backend\V1\PermissionController@delete']);
        Route::get('modules/permission/backend/v1/permission/export-csv', ['as' => 'modules.permission.backend.v1.permission.export-csv', 'uses' => '\Modules\Permission\Http\Controllers\Backend\V1\PermissionController@exportCsv']);
    });
});
