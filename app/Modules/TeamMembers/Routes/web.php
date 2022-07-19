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


Route::prefix('team-members')->middleware('auth')->group(function () {
    Route::get('/', 'TeamMembersController@index')->middleware(['permission:list-team-member'])->name('get.team-member.list');
    Route::get('/by-team/{id}', 'TeamMembersController@indexByTeam')->middleware(['permission:list-team-member'])->name('get.team-member.list-by-team');
    Route::get('/create', 'TeamMembersController@create')->middleware(['permission:list-team-member|create-team-member'])->name('get.team-member.create');
    Route::post('/create', 'TeamMembersController@store')->middleware(['permission:list-team-member|create-team-member'])->name('post.team-member.create');
    Route::get('/edit/{id}', 'TeamMembersController@edit')->middleware(['permission:list-team-member|edit-team-member'])->name('get.team-member.edit');
    Route::post('/edit/{id}', 'TeamMembersController@update')->middleware(['permission:list-team-member|edit-team-member'])->name('post.team-member.edit');
    Route::get('/show/{id}', 'TeamMembersController@show')->middleware(['permission:list-team-member|view-team-member-stats'])->name('get.team-member.show');
    Route::get('/statistics/{id}', 'TeamMembersController@statistics')->middleware(['permission:permission:list-team-member|view-team-member-stats'])->name('get.team-member.statistics');
    Route::get('/delete/{id}', 'TeamMembersController@destroy')->middleware(['permission:list-team-member|delete-team-member'])->name('get.team-member.delete');
});
