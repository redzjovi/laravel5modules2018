<?php

Route::group(['middleware' => 'web', 'prefix' => 'queue', 'namespace' => 'Modules\Queue\Http\Controllers'], function()
{
    Route::get('/', 'QueueController@index');
});
