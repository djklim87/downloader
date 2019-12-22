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

Route::get('/', 'WebController@results');
Route::get('/add', 'WebController@add');
Route::post('/enqueue', 'WebController@enqueue');
Route::get('/download/{id}', 'WebController@download');
