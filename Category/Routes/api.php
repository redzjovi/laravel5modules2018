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

Route::get('v1/category')->name('api.v1.category.index')->uses('Api\V1\CategoryController@index');
Route::post('v1/category')->name('api.v1.category.store')->uses('Api\V1\CategoryController@store');
Route::get('v1/category/{category}')->name('api.v1.category.show')->uses('Api\V1\CategoryController@show');
Route::put('v1/category/{category}')->middleware(['auth:api', 'permission:api.v1.category.*'])->name('api.v1.category.update')->uses('Api\V1\CategoryController@update');
Route::delete('v1/category/{category}')->middleware(['auth:api', 'permission:api.v1.category.*'])->name('api.v1.category.destroy')->uses('Api\V1\CategoryController@destroy');
