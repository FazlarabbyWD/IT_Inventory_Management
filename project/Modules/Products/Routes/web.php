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

Route::prefix('products')->group(function() {
    Route::get('/', 'ProductsController@index')->name('Products');
    Route::get('/create', 'ProductsController@create')->name('Products Create');
    Route::post('/store', 'ProductsController@store')->name('Products Store');
    Route::get('/edit/{id}', 'ProductsController@edit')->name('Products Edit');
    Route::post('/update/{id}', 'ProductsController@update')->name('Products Update');
    Route::get('/delete/{id}', 'ProductsController@destroy')->name('Products Delete');
    Route::get('/stock/create/{id}', 'ProductsController@stockCreate')->name('Products Stock Create');
    Route::post('/stock/store/{id}', 'ProductsController@stockStore')->name('Products Stock Store');
    Route::get('/stock/list/{id}', 'ProductsController@stockList')->name('Products Stock List');
    Route::get('/stock/edit/{stockId}', 'ProductsController@stockEdit')->name('Products Stock Edit');
    Route::post('/stock/update/{stockId}', 'ProductsController@stockUpdate')->name('Products Stock Update');
    Route::get('/stock/delete/{stockId}', 'ProductsController@destroyStock')->name('Products Stock Delete');

    Route::get('/ajax/get/products', 'ProductsController@ajaxGetProducts')->name('Products Ajax Get List');
    Route::get('/ajax/get/spectypes/{id}', 'ProductsController@ajaxGetProductSpecTypes')->name('Products Ajax Get Spec Types');
    Route::get('/ajax/get/items/{productId}', 'ProductsController@ajaxGetProductItems')->name('Products Ajax Get Items');
});
