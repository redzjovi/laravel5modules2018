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

Route::get('v1/theme')->name('api.v1.theme.index')->uses('Api\V1\ThemeController@index');
Route::post('v1/theme')->middleware(['auth:api', 'permission:api.v1.theme.*'])->name('api.v1.theme.store')->uses('Api\V1\ThemeController@store');
Route::get('v1/theme/{theme}')->name('api.v1.theme.show')->uses('Api\V1\ThemeController@show');
Route::put('v1/theme/{theme}')->middleware(['auth:api', 'permission:api.v1.theme.*'])->name('api.v1.theme.update')->uses('Api\V1\ThemeController@update');
Route::delete('v1/theme/{theme}')->middleware(['auth:api', 'permission:api.v1.theme.*'])->name('api.v1.theme.destroy')->uses('Api\V1\ThemeController@destroy');
