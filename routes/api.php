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

//Route::middleware('auth:api')->group(function () {
//    Route::get('/abc', 'API\BookController@index');
//
//});, 'prefix' => 'v1/books'    ,


Route::group(['prefix' => 'v1/books', 'middleware'=> 'auth:api'], function(){
    Route::get('/list', 'API\BookController@index');
    Route::get('/by-id/{book}', 'API\BookController@show');
    Route::post('/update/{book}', 'API\BookController@update');
    Route::delete('/{book}', 'API\BookController@delete');
});
