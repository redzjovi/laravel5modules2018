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
    Route::group(['middleware' => ['permission:modules.theme.backend.v1.theme.*']], function () {
        Route::resource('modules/theme/backend/v1/theme', 'Backend\V1\ThemeController', ['as' => 'modules.theme.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/theme/backend/v1/theme/action')->name('modules.theme.backend.v1.theme.action')->uses('Backend\V1\ThemeController@action');
        Route::get('modules/theme/backend/v1/theme/delete/{theme}')->name('modules.theme.backend.v1.theme.delete')->uses('Backend\V1\ThemeController@delete');
        Route::get('modules/theme/backend/v1/theme/export-csv')->name('modules.theme.backend.v1.theme.export-csv')->uses('Backend\V1\ThemeController@exportCsv');
    });
});
