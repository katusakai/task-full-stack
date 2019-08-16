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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::get('/users/{search}', 'UserController@index')->name('user.index');
Route::post('/users', 'UserController@store')->name('users.store');
Route::put('/users/{user}', 'UserController@update')->name('user.update');
Route::delete('/users/{user}', 'UserController@destroy')->name('user.destroy');

Route::post('/users/random', 'UserController@storeRandom')->name('users.store.random');