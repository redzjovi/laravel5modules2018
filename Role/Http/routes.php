<?php

use Modules\Authentication\Http\Middleware\Backend\V1\AuthenticationMiddleware;

Route::group(['middleware' => ['web']], function() {
    Route::group(['middleware' => [AuthenticationMiddleware::class]], function() {
        Route::resource('modules/role/backend/v1/role', '\Modules\Role\Http\Controllers\Backend\V1\RoleController', ['as' => 'modules.role.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/role/backend/v1/role/action', ['as' => 'modules.role.backend.v1.role.action', 'uses' => '\Modules\Role\Http\Controllers\Backend\V1\RoleController@action']);
        Route::get('modules/role/backend/v1/role/{role}/delete', ['as' => 'modules.role.backend.v1.role.delete', 'uses' => '\Modules\Role\Http\Controllers\Backend\V1\RoleController@delete']);
        Route::get('modules/role/backend/v1/role/export-csv', ['as' => 'modules.role.backend.v1.role.export-csv', 'uses' => '\Modules\Role\Http\Controllers\Backend\V1\RoleController@exportCsv']);
        Route::resource('modules/role/backend/v1/role/permission', '\Modules\Role\Http\Controllers\Backend\V1\Role\PermissionController', ['as' => 'modules.role.backend.v1.role'])->only(['edit', 'update']);
    });
});
