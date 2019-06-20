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

Route::view('/{path?}', 'app');

//Route::get('/', 'ItemController@index');
//Route::get('/{id}', 'ItemController@items');

Route::get('/test/show', "TestController@index");

//test socket io
Route::get('/socket', "SocketController@index");
Route::get('/sendmessage', 'SocketController@sendMessage');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
