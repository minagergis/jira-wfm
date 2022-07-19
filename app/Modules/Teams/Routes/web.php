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

Route::prefix('teams')->middleware('auth')->group(function () {
    Route::get('/', 'TeamsController@index')->middleware(['permission:list-team'])->name('get.teams.list');
    Route::get('/create', 'TeamsController@create')->middleware(['permission:list-team|create-team'])->name('get.teams.create');
    Route::post('/create', 'TeamsController@store')->middleware(['permission:list-team|create-team'])->name('post.teams.create');
    Route::get('/edit/{id}', 'TeamsController@edit')->middleware(['permission:list-team|edit-team'])->name('get.teams.edit');
    Route::post('/edit/{id}', 'TeamsController@update')->middleware(['permission:list-team|edit-team'])->name('post.teams.edit');
    Route::get('/show/{id}', 'TeamsController@show')->middleware(['permission:list-team|edit-team'])->name('get.teams.show');
    Route::get('/delete/{id}', 'TeamsController@destroy')->middleware(['permission:list-team|delete-team'])->name('get.teams.delete');
});
