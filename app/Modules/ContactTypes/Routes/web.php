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

Route::prefix('contact-types')->middleware('auth')->group(function () {
    Route::get('/', 'ContactTypesController@index')->name('get.contact-type.list');
    Route::get('/create', 'ContactTypesController@create')->name('get.contact-type.create');
    Route::post('/create', 'ContactTypesController@store')->name('post.contact-type.create');
    Route::get('/edit/{id}', 'ContactTypesController@edit')->name('get.contact-type.edit');
    Route::post('/edit/{id}', 'ContactTypesController@update')->name('post.contact-type.edit');
});
