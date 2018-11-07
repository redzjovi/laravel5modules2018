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

Route::group(['middleware' => [AuthenticationMiddleware::class]], function() {
    Route::group(['middleware' => ['permission:modules.permission.backend.v1.permission.*']], function() {
        Route::resource('modules/permission/backend/v1/permission', 'Backend\V1\PermissionController', ['as' => 'modules.permission.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/permission/backend/v1/permission/action')->name('modules.permission.backend.v1.permission.action')->uses('Backend\V1\PermissionController@action');
        Route::get('modules/permission/backend/v1/permission/delete/{permission}')->name('modules.permission.backend.v1.permission.delete')->uses('Backend\V1\PermissionController@delete');
        Route::get('modules/permission/backend/v1/permission/export-csv')->name('modules.permission.backend.v1.permission.export-csv')->uses('Backend\V1\PermissionController@exportCsv');
    });
});
