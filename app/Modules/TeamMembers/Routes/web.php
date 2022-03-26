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

Route::prefix('team-members')->group(function() {
    Route::get('/', 'TeamMembersController@index')->name('get.team-member.list');
    Route::get('/create', 'TeamMembersController@create')->name('get.team-member.create');
    Route::post('/create', 'TeamMembersController@store')->name('post.team-member.create');
    Route::get('/edit/{id}', 'TeamMembersController@edit')->name('get.team-member.edit');
    Route::post('/edit/{id}', 'TeamMembersController@update')->name('post.team-member.edit');
    Route::get('/show/{id}', 'TeamMembersController@show')->name('get.team-member.show');
    Route::get('/delete/{id}', 'TeamMembersController@destroy')->name('get.team-member.delete');
});
