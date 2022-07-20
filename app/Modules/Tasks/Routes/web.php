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

use Illuminate\Support\Facades\Route;

Route::prefix('tasks')->middleware('auth')->group(function () {
    Route::get('/', 'TasksController@index')->middleware(['permission:list-task'])->name('get.tasks.list');
    Route::get('/create', 'TasksController@create')->middleware(['permission:list-task|create-task'])->name('get.tasks.create');
    Route::post('/create', 'TasksController@store')->middleware(['permission:list-task|create-task'])->name('post.tasks.create');
    Route::get('/edit/{id}', 'TasksController@edit')->middleware(['permission:list-task|edit-task'])->name('get.tasks.edit');
    Route::post('/edit/{id}', 'TasksController@update')->middleware(['permission:list-task|edit-task'])->name('post.tasks.edit');
    Route::get('/show/{id}', 'TasksController@show')->middleware(['permission:list-task|edit-task'])->name('get.tasks.show');
    Route::get('/delete/{id}', 'TasksController@destroy')->middleware(['permission:list-task|delete-task'])->name('get.tasks.delete');
});
