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

Route::get('v1/menu')->name('api.v1.menu.index')->uses('Api\V1\MenuController@index');
Route::post('v1/menu')->middleware(['auth:api', 'permission:api.v1.menu.*'])->name('api.v1.menu.store')->uses('Api\V1\MenuController@store');
Route::get('v1/menu/{menu}')->name('api.v1.menu.show')->uses('Api\V1\MenuController@show');
Route::put('v1/menu/{menu}')->middleware(['auth:api', 'permission:api.v1.menu.*'])->name('api.v1.menu.update')->uses('Api\V1\MenuController@update');
Route::delete('v1/menu/{menu}')->middleware(['auth:api', 'permission:api.v1.menu.*'])->name('api.v1.menu.destroy')->uses('Api\V1\MenuController@destroy');
Route::get('v1/menu/nestable/type')->name('api.v1.menu.nestable.type.index')->uses('Api\V1\Menu\Nestable\TypeController@index');
Route::get('v1/menu/nestable/type-title')->name('api.v1.menu.nestable.type-title.index')->uses('Api\V1\Menu\Nestable\TypeTitleController@index');
