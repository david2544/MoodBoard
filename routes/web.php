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

// Retruns the welcoming page to the website root
Route::get('/', function () {
    return view('welcome');
});

// Receives the payload from slack and identifies if it comes from a click of a button or if its from an outgoing webhook
Route::post('/hook', 'BaseController@hook');

// Dumps the database data under the /hook view
Route::get('/hook', 'BaseController@dump');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
