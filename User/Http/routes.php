<?php

Route::group(['middleware' => ['web']], function() {
    Route::resource('modules/user/backend/v1/user', '\Modules\User\Http\Controllers\Backend\V1\UserController', ['as' => 'modules.user.backend.v1'])->only(['index', 'create', 'store', 'edit', 'update']);
    Route::post('modules/user/backend/v1/user/action', ['as' => 'modules.user.backend.v1.user.action', 'uses' => '\Modules\User\Http\Controllers\Backend\V1\UserController@action']);
    Route::get('modules/user/backend/v1/user/{user}/delete', ['as' => 'modules.user.backend.v1.user.delete', 'uses' => '\Modules\User\Http\Controllers\Backend\V1\UserController@delete']);
    Route::get('modules/user/backend/v1/user/export-csv', ['as' => 'modules.user.backend.v1.user.export-csv', 'uses' => '\Modules\User\Http\Controllers\Backend\V1\UserController@exportCsv']);
});
