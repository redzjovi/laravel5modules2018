<?php

Route::group(['middleware' => 'web', 'prefix' => 'role', 'namespace' => 'Modules\Role\Http\Controllers'], function()
{
    Route::get('/', 'RoleController@index');
});
