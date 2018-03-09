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
    return view('welcome');
});

Route::post('/hook', 'BaseController@hook');

Route::get('/outgoing', 'BaseController@outgoing');

Route::get('/dump', 'BaseController@dump');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
