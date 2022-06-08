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

Route::prefix('shifts')->group(function () {
    Route::get('/', 'ShiftsController@index')->name('get.shifts.list');
    Route::get('/by-team/{id}', 'ShiftsController@indexByTeam')->name('get.shifts.list-by-team');
    Route::get('/create', 'ShiftsController@create')->name('get.shifts.create');
    Route::post('/create', 'ShiftsController@store')->name('post.shifts.create');
    Route::get('/edit/{id}', 'ShiftsController@edit')->name('get.shifts.edit');
    Route::post('/edit/{id}', 'ShiftsController@update')->name('post.shifts.edit');
});

Route::prefix('schedule')->group(function () {
    Route::get('/by-team/{id}', 'ScheduleController@scheduleCalendarForTeam')->name('get.schedule.list-by-team');
    Route::post('/add-schedule', 'ScheduleController@addSchedule')->name('post.schedule.add');
    Route::post('/delete-schedule', 'ScheduleController@deleteSchedule')->name('post.schedule.delete');
});
