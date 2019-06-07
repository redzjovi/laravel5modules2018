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

Route::post('authentication/login')->name('api.authentication.login.store')->uses('Api\Authentication\LoginController@store');
Route::post('authentication/logout')->middleware(['auth:api'])->name('api.authentication.logout.store')->uses('Api\Authentication\LogoutController@store');
Route::post('authentication/password/forgot')->name('api.authentication.password.forgot.store')->uses('Api\Authentication\Password\ForgotController@store');
Route::put('authentication/password/reset')->name('api.authentication.password.reset.store')->uses('Api\Authentication\Password\ResetController@update');
