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

Route::get('/', function () {
    return view('index', ['authors' => \App\Author::all()]);
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('books', 'BookController')->middleware('auth');

Route::resource('authors', 'AuthorController')->middleware('auth');

Route::get('/token', 'API\TokenController@update')->middleware('auth');