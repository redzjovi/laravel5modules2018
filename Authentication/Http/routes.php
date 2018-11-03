<?php

Route::group(['middleware' => ['web']], function () {
    Route::get('modules/authentication/backend/v1/authentication/login', ['as' => 'modules.authentication.backend.v1.authentication.login.index', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\LoginController@index']);
    Route::post('modules/authentication/backend/v1/authentication/login', ['as' => 'modules.authentication.backend.v1.authentication.login.store', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\LoginController@store']);
    Route::post('modules/authentication/backend/v1/authentication/logout', ['as' => 'modules.authentication.backend.v1.authentication.logout.store', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\LogoutController@store']);
    Route::get('modules/authentication/backend/v1/authentication/password/forgot', ['as' => 'modules.authentication.backend.v1.authentication.password.forgot.index', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password\ForgotController@index']);
    Route::post('modules/authentication/backend/v1/authentication/password/forgot', ['as' => 'modules.authentication.backend.v1.authentication.password.forgot.store', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password\ForgotController@store']);
    Route::get('modules/authentication/backend/v1/authentication/password/reset', ['as' => 'modules.authentication.backend.v1.authentication.password.reset.index', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password\ResetController@index']);
    Route::put('modules/authentication/backend/v1/authentication/password/reset', ['as' => 'modules.authentication.backend.v1.authentication.password.reset.update', 'uses' => '\Modules\Authentication\Http\Controllers\Backend\V1\Authentication\Password\ResetController@update']);
});
