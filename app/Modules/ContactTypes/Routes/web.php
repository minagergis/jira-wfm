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
    Route::get('/', 'ContactTypesController@index')->middleware(['permission:list-contact-type'])->name('get.contact-type.list');
    Route::get('/create', 'ContactTypesController@create')->middleware(['permission:list-contact-type|create-contact-type'])->name('get.contact-type.create');
    Route::post('/create', 'ContactTypesController@store')->middleware(['permission:list-contact-type|create-contact-type'])->name('post.contact-type.create');
    Route::get('/edit/{id}', 'ContactTypesController@edit')->middleware(['permission:list-contact-type|edit-contact-type'])->name('get.contact-type.edit');
    Route::post('/edit/{id}', 'ContactTypesController@update')->middleware(['permission:list-contact-type|edit-contact-type'])->name('post.contact-type.edit');
});
