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
    Route::group(['middleware' => ['permission:modules.page.backend.v1.page.*']], function() {
        Route::resource('modules/page/backend/v1/page', 'Backend\V1\PageController', ['as' => 'modules.page.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/page/backend/v1/page/action')->name('modules.page.backend.v1.page.action')->uses('Backend\V1\PageController@action');
        Route::get('modules/page/backend/v1/page/delete/{page}')->name('modules.page.backend.v1.page.delete')->uses('Backend\V1\PageController@delete');
        Route::get('modules/page/backend/v1/page/export-csv')->name('modules.page.backend.v1.page.export-csv')->uses('Backend\V1\PageController@exportCsv');
    });
});
