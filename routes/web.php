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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'ThreadsController@index');

Auth::routes();

Route::get('/home', 'ThreadsController@index');

Route::get('/threads', 'ThreadsController@index')->name('threads');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::post('/threads', 'ThreadsController@store')->name('threads');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::get('/threads/{channel}', 'ThreadsController@index')->name('threads.channel');
// Route::resource('threads','ThreadsController');

// Route::post('/threads/{thread}/replies', 'ThreadsController@addReply')->name('threads.addReply');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('reply.store');

Route::post('replies/{reply}/favorites','FavoritesController@store');