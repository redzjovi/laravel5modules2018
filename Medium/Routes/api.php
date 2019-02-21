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

Route::resource('v1/medium/tinymce/image', 'Api\V1\Medium\Tinymce\ImageController', ['as' => 'api.v1.medium.tinymce'])->only(['store']);
