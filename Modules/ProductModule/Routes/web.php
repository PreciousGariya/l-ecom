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
Route::group(['prefix' => 'admin', 'middleware' => ['role:admin', 'auth']], function () {

    Route::prefix('products')->group(function () {


        Route::get('/create', 'ProductModuleController@create')->name('products.create');
        Route::get('/products/import/csv', 'ProductModuleController@import')->name('products.import');
        Route::post('/products/import/store', 'ProductModuleController@import_store')->name('products.import_store');



        Route::get('/edit/{id}', 'ProductModuleController@edit')->name('products.edit');
        Route::post('/update/{id}', 'ProductModuleController@update')->name('products.update');
        Route::post('/store', 'ProductModuleController@store')->name('products.store');
        //
    });

    //
    //
    // Category
    Route::prefix('category')->group(function () {
        Route::get('/', 'CategoryController@index')->name('category.index');
        Route::get('/create', 'CategoryController@create')->name('category.create');
        Route::get('/edit/{id}', 'CategoryController@edit')->name('category.edit');
        Route::post('/update/{id}', 'CategoryController@update')->name('category.update');
        Route::post('/store', 'CategoryController@store')->name('category.store');
        Route::post('/category/import/store', 'CategoryController@import_store')->name('category.import_store');
    });

    //


});
Route::prefix('products')->group(function () {
    Route::get('/', 'ProductModuleController@index')->name('index');
    Route::get('/Product/view/{slug}', 'ProductModuleController@show')->name('products.view');
    Route::get('/show/{id}', 'ProductModuleController@show')->name('products.show');
});
Route::prefix('category')->group(function () {

    Route::get('/show/{id}', 'CategoryController@show')->name('category.show');
});
