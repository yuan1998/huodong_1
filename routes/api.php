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

Route::group([
    'middleware' => ['bindings']
],function () {
    Route::post('/huodong' , 'HuodongLogController@store');
    Route::post('/huodong/image/{huodongLog}' , 'HuodongLogController@uploadImage');
    Route::get('/huodong/number' , 'HuodongLogController@getNumber');

});

