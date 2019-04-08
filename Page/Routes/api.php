<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('v1/page')->name('api.v1.page.index')->uses('Api\V1\PageController@index');
Route::post('v1/page')->middleware(['auth:api', 'permission:api.v1.page.*'])->name('api.v1.page.store')->uses('Api\V1\PageController@store');
Route::get('v1/page/{page}')->name('api.v1.page.show')->uses('Api\V1\PageController@show');
Route::put('v1/page/{page}')->middleware(['auth:api', 'permission:api.v1.page.*'])->name('api.v1.page.update')->uses('Api\V1\PageController@update');
Route::delete('v1/page/{page}')->middleware(['auth:api', 'permission:api.v1.page.*'])->name('api.v1.page.destroy')->uses('Api\V1\PageController@destroy');
