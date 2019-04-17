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

Route::get('v1/tag')->name('api.v1.tag.index')->uses('Api\V1\TagController@index');
Route::post('v1/tag')->name('api.v1.tag.store')->uses('Api\V1\TagController@store');
Route::get('v1/tag/{tag}')->name('api.v1.tag.show')->uses('Api\V1\TagController@show');
Route::put('v1/tag/{tag}')->middleware(['auth:api', 'permission:api.v1.tag.*'])->name('api.v1.tag.update')->uses('Api\V1\TagController@update');
Route::delete('v1/tag/{tag}')->middleware(['auth:api', 'permission:api.v1.tag.*'])->name('api.v1.tag.destroy')->uses('Api\V1\TagController@destroy');
