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

//---MAIN---//
Route::get('/items', 'ItemAPIController@index');

//---------//
Route::get('/seen', function() {
    return ["id"=>"hello"];
});

Route::get('/{id}', 'ItemController@items');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
