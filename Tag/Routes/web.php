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
    Route::group(['middleware' => ['permission:modules.tag.backend.v1.tag.*']], function () {
        Route::resource('modules/tag/backend/v1/tag', 'Backend\V1\TagController', ['as' => 'modules.tag.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/tag/backend/v1/tag/action')->name('modules.tag.backend.v1.tag.action')->uses('Backend\V1\TagController@action');
        Route::get('modules/tag/backend/v1/tag/delete/{tag}')->name('modules.tag.backend.v1.tag.delete')->uses('Backend\V1\TagController@delete');
        Route::get('modules/tag/backend/v1/tag/export-csv')->name('modules.tag.backend.v1.tag.export-csv')->uses('Backend\V1\TagController@exportCsv');
    });
});
