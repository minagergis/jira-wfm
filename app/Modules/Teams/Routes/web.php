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

Route::prefix('teams')->middleware('auth')->group(function () {
    Route::get('/', 'TeamsController@index')->name('get.teams.list');
    Route::get('/create', 'TeamsController@create')->name('get.teams.create');
    Route::post('/create', 'TeamsController@store')->name('post.teams.create');
    Route::get('/edit/{id}', 'TeamsController@edit')->name('get.teams.edit');
    Route::post('/edit/{id}', 'TeamsController@update')->name('post.teams.edit');
    Route::get('/show/{id}', 'TeamsController@show')->name('get.teams.show');
    Route::get('/delete/{id}', 'TeamsController@destroy')->name('get.teams.delete');
    Route::get('/calendar/{id}', 'TeamsController@scheduleCalendar')->name('get.teams.calendar');
});
