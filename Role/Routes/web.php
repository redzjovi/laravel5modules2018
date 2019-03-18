<?php

use Modules\Authentication\Http\Middleware\Backend\V1\AuthenticationMiddleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => [AuthenticationMiddleware::class]], function () {
    Route::group(['middleware' => ['permission:modules.role.backend.v1.role.*']], function () {
        Route::resource('modules/role/backend/v1/role', 'Backend\V1\RoleController', ['as' => 'modules.role.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/role/backend/v1/role/action')->name('modules.role.backend.v1.role.action')->uses('Backend\V1\RoleController@action');
        Route::get('modules/role/backend/v1/role/delete/{role}')->name('modules.role.backend.v1.role.delete')->uses('Backend\V1\RoleController@delete');
        Route::get('modules/role/backend/v1/role/export-csv')->name('modules.role.backend.v1.role.export-csv')->uses('Backend\V1\RoleController@exportCsv');
    });
    Route::group(['middleware' => ['permission:modules.role.backend.v1.role.permission.*']], function () {
        Route::get('modules/role/backend/v1/role/permission/{role}')->name('modules.role.backend.v1.role.permission.edit')->uses('Backend\V1\Role\PermissionController@edit');
        Route::put('modules/role/backend/v1/role/permission/{role}')->name('modules.role.backend.v1.role.permission.update')->uses('Backend\V1\Role\PermissionController@update');
    });
});
