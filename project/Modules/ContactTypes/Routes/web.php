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

Route::prefix('contacttypes')->group(function() {
    Route::get('/', 'ContactTypesController@index')->name('ContactTypes');
    Route::get('/create', 'ContactTypesController@create')->name('ContactTypes Create');
    Route::post('/store', 'ContactTypesController@store')->name('ContactTypes Store');
    Route::get('/edit/{id}', 'ContactTypesController@edit')->name('ContactTypes Edit');
    Route::post('/update/{id}', 'ContactTypesController@update')->name('ContactTypes Update');
    Route::get('/delete/{id}', 'ContactTypesController@destroy')->name('ContactTypes Delete');
});
