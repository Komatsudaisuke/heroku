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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin'], function() {
    Route::get('news2/create', 'Admin\NewsController2@add')->middleware('auth');
    Route::post('news2/create', 'Admin\NewsController2@create')->middleware('auth');;
    Route::get('news2', 'Admin\NewsController2@index')->middleware('auth');
    Route::get('news2/edit', 'Admin\NewsController2@edit')->middleware('auth'); // 追記
    Route::post('news2/edit', 'Admin\NewsController2@update')->middleware('auth');
    Route::get('news/delete', 'Admin\NewsController@delete')->middleware('auth');
    
});

Route::get('/', 'NewsController@index');