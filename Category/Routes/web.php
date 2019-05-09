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
    Route::group(['middleware' => ['permission:modules.category.backend.v1.category.*']], function () {
        Route::resource('modules/category/backend/v1/category', 'Backend\V1\CategoryController', ['as' => 'modules.category.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
        Route::post('modules/category/backend/v1/category/action')->name('modules.category.backend.v1.category.action')->uses('Backend\V1\CategoryController@action');
        Route::get('modules/category/backend/v1/category/delete/{category}')->name('modules.category.backend.v1.category.delete')->uses('Backend\V1\CategoryController@delete');
        Route::get('modules/category/backend/v1/category/export-csv')->name('modules.category.backend.v1.category.export-csv')->uses('Backend\V1\CategoryController@exportCsv');
    });
});
