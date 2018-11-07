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
    Route::group(['middleware' => ['permission:modules.user.backend.v1.user.*']], function() {
        Route::resource('modules/user/backend/v1/user', 'Backend\V1\UserController', ['as' => 'modules.user.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/user/backend/v1/user/action')->name('modules.user.backend.v1.user.action')->uses('Backend\V1\UserController@action');
        Route::get('modules/user/backend/v1/user/delete/{user}')->name('modules.user.backend.v1.user.delete')->uses('Backend\V1\UserController@delete');
        Route::get('modules/user/backend/v1/user/export-csv')->name('modules.user.backend.v1.user.export-csv')->uses('Backend\V1\UserController@exportCsv');
    });
});
