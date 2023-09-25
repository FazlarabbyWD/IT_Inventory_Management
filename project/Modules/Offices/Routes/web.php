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

Route::prefix('offices')->group(function() {
    Route::get('/', 'OfficesController@index')->name('Offices');
    Route::get('/create', 'OfficesController@create')->name('Offices Create');
    Route::post('/store', 'OfficesController@store')->name('Offices Store');
    Route::get('/edit/{id}', 'OfficesController@edit')->name('Offices Edit');
    Route::post('/update/{id}', 'OfficesController@update')->name('Offices Update');
    Route::get('/delete/{id}', 'OfficesController@destroy')->name('Offices Delete');
});
