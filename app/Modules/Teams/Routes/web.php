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

Route::prefix('teams')->group(function() {
    Route::get('/', 'TeamsController@index')->name('get.teams.list');
    Route::get('/create', 'TeamsController@create')->name('get.teams.create');
    Route::post('/create', 'TeamsController@store')->name('post.teams.create');
});
