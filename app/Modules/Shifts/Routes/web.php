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

Route::prefix('shifts')->group(function () {
    Route::get('/', 'ShiftsController@index')->name('get.shifts.list');
    Route::get('/create', 'ShiftsController@create')->name('get.shifts.create');
    Route::post('/create', 'ShiftsController@store')->name('post.shifts.create');
});
