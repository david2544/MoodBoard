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

//returns the welcome view at the root of the website
Route::get('/', function () {
    return view('welcome');
});

//Calls BaseController hook function when a post request is received
Route::post('/hook', 'BaseController@hook');

//Calls BaseController dump function which dumps the database
Route::get('/dump', 'BaseController@dump');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
