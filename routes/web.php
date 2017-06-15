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
Route::get('/', 'TicketsController@index')->name('dashboard');
Route::get('/tickets/status/{id?}', 'TicketsController@list')->name('tickets.list');
Route::get('/tickets/create', 'TicketsController@create')->name('tickets.create');
Route::post('/tickets/create', 'TicketsController@store')->name('tickets.store');
Route::get('/tickets/{ticket}', 'TicketsController@show')->name('tickets.show');
Route::get('/tickets/edit/{ticket}', 'TicketsController@edit')->name('tickets.edit');
Route::post('/tickets/edit/{ticket}', 'TicketsController@update')->name('tickets.update');
Route::post('/tickets/close/{ticket}', 'TicketsController@closed')->name('tickets.close');
Route::get('/users/', 'UsersController@index')->name('users.index');
Route::get('/users/edit/{user}', 'UsersController@edit')->name('users.close');
Route::get('logout', 'HomeController@logout')->name('logout');
