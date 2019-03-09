<?php

use Illuminate\Http\Request;

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

Route::group(['middleware' => []], function () {
    Route::resource('v1/user', 'Api\V1\UserController', ['as' => 'api'])->only(['index', 'store', 'show', 'update', 'destroy']);
});
