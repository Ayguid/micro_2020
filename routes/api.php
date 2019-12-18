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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//filter api
Route::get('/getProducts/{ctyId}/{catId}/{filterAtts?}', 'FilterController@findProducts');



//media manager
Route::post('/files/upload', 'Admin\FileController@upload');
Route::post('/files/destroy/{string?}', 'Admin\FileController@destroy');
