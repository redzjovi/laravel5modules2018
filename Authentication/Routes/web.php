<?php

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

Route::get('modules/authentication/backend/v1/authentication/login')->name('modules.authentication.backend.v1.authentication.login.index')->uses('Backend\V1\Authentication\LoginController@index');
Route::post('modules/authentication/backend/v1/authentication/login')->name('modules.authentication.backend.v1.authentication.login.store')->uses('Backend\V1\Authentication\LoginController@store');
Route::post('modules/authentication/backend/v1/authentication/logout')->name('modules.authentication.backend.v1.authentication.logout.store')->uses('Backend\V1\Authentication\LogoutController@store');
Route::get('modules/authentication/backend/v1/authentication/password/forgot')->name('modules.authentication.backend.v1.authentication.password.forgot.index')->uses('Backend\V1\Authentication\Password\ForgotController@index');
Route::post('modules/authentication/backend/v1/authentication/password/forgot')->name('modules.authentication.backend.v1.authentication.password.forgot.store')->uses('Backend\V1\Authentication\Password\ForgotController@store');
Route::get('modules/authentication/backend/v1/authentication/password/reset')->name('modules.authentication.backend.v1.authentication.password.reset.index')->uses('Backend\V1\Authentication\Password\ResetController@index');
Route::put('modules/authentication/backend/v1/authentication/password/reset')->name('modules.authentication.backend.v1.authentication.password.reset.update')->uses('Backend\V1\Authentication\Password\ResetController@update');
