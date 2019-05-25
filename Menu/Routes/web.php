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
    Route::group(['middleware' => ['permission:modules.menu.backend.v1.menu.*']], function () {
        Route::resource('modules/menu/backend/v1/menu', 'Backend\V1\MenuController', ['as' => 'modules.menu.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/menu/backend/v1/menu/action')->name('modules.menu.backend.v1.menu.action')->uses('Backend\V1\MenuController@action');
        Route::get('modules/menu/backend/v1/menu/delete/{menu}')->name('modules.menu.backend.v1.menu.delete')->uses('Backend\V1\MenuController@delete');
        Route::get('modules/menu/backend/v1/menu/export-csv')->name('modules.menu.backend.v1.menu.export-csv')->uses('Backend\V1\MenuController@exportCsv');
    });
});
