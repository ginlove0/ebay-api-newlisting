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
// exclude the keywords
Route::apiResource('/keywords/blacklist', 'KeywordAPIController');

Route::get('/calculate', 'KeywordAPIController@calculateExcludeMatch');

// important keywords
Route::apiResource('/keywords', 'ImportantKeywordAPIController');




Route::get('/items', 'ItemAPIController@index');
Route::get('/items/{id}', 'ItemAPIController@show');
Route::post('/items/truncate', 'ItemAPIController@clearAllData');
Route::post('/set-seen-all', 'ItemAPIController@seen');
Route::get('/mobile/items', 'ItemAPIController@indexMobile');
// Blacklist
// item blacklist
Route::post('/items/blacklist', 'ItemAPIController@blackList');

// seller blacklist
Route::apiResource('/seller/blacklist', 'SellerBlacklistAPIController');
// Route::post('/seller/blacklist', 'ItemAPIController@excludeSeller');
// Route::delete('/seller/blacklist', 'ItemAPIController@removeExcludeSeller');

// category blacklist CRUD
Route::apiResource('/category/blacklist', 'CategoryBlacklistAPIController');
// // Read
// Route::get('/category/blacklist', 'BlacklistCategoryAPIController@index_category');
// // Created
// Route::post('/category/blacklist', 'BlacklistCategoryAPIController@blacklist_category');

//---------//


Route::get('/seen', function() {
    return ["hello"=>"world"];
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
