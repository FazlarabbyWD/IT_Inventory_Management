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

Route::prefix('distributions')->group(function() {
    Route::get('/', 'DistributionsController@index')->name('Distributions');
    Route::get('/create', 'DistributionsController@create')->name('Distributions Create');
    Route::post('/store', 'DistributionsController@store')->name('Distributions Store');
    Route::get('/edit/{id}', 'DistributionsController@edit')->name('Distributions Edit');
    Route::post('/update/{id}', 'DistributionsController@update')->name('Distributions Update');
    Route::get('/delete/{id}', 'DistributionsController@destroy')->name('Distributions Delete');
});
