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

Route::prefix('tasks')->group(function() {
    Route::get('/', 'TasksController@index')->name('get.tasks.list');
    Route::get('/create', 'TasksController@create')->name('get.tasks.create');
    Route::post('/create', 'TasksController@store')->name('post.tasks.create');
    Route::get('/edit/{id}', 'TasksController@edit')->name('get.tasks.edit');
    Route::post('/edit/{id}', 'TasksController@update')->name('post.tasks.edit');
    Route::get('/show/{id}', 'TasksController@show')->name('get.tasks.show');
    Route::get('/delete/{id}', 'TasksController@destroy')->name('get.tasks.delete');
});
