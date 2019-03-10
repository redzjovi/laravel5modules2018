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

Route::post('v1/authentication/login')->name('api.v1.authentication.login.store')->uses('Api\V1\Authentication\LoginController@store');

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('v1/authentication/logout')->name('api.v1.authentication.logout.store')->uses('Api\V1\Authentication\LogoutController@store');
});

Route::post('v1/authentication/password/forgot')->name('api.v1.authentication.password.forgot.store')->uses('Api\V1\Authentication\Password\ForgotController@store');
Route::put('v1/authentication/password/reset')->name('api.v1.authentication.password.reset.store')->uses('Api\V1\Authentication\Password\ResetController@update');
