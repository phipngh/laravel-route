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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->group(function () {
    Route::get('/index','AdminController@index');
    Route::get('/catelogies','AdminController@catelogies')->name('adminCatelogies');
    Route::post('/catelogies','AdminController@createCatelogies')->name('adminCreateCatelogies');

    Route::post('/catelogies/{id}/delete','AdminController@deleteCatelogies')->name('adminDeleteCatelogies');


    Route::get('/testfactory','TestFactoryController@index')->name('testfactory.index');



    Route::get('/catelogy','AdminController@catelogy')->name('catelogy.index');
    Route::post('/catelogy','AdminController@catelogyStore')->name('catelogy.store');



    //catelogys
    Route::get('catelogys','CatelogyController@index')->name('catelogys.index');
    Route::post('catelogys','CatelogyController@store')->name('catelogys.store');
    Route::get('catelogys/{id}/edit','CatelogyController@edit')->name('catelogys.edit');
    Route::post('catelogys/update','CatelogyController@update')->name('catelogys.update');
    Route::get('catelogys/destroy/{id}','CatelogyController@destroy');
    Route::post('catelogys/import','CatelogyController@import')->name('catelogy.import');
    Route::get('catelogys/export/', 'CatelogyController@export')->name('catelogy.export');

    //gender
    Route::get('gender','GenderController@index')->name('gender.index');
    Route::post('gender','GenderController@store')->name('gender.store');
    Route::get('gender/{id}/edit','GenderController@edit')->name('gender.edit');
    Route::post('gender/update','GenderController@update')->name('gender.update');
    Route::get('gender/destroy/{id}','GenderController@destroy');
    Route::post('gender/import','GenderController@import')->name('gender.import');
    Route::get('gender/export/', 'GenderController@export')->name('gender.export');

    //product
    Route::get('product','ProductController@index')->name('product.index');
    Route::post('product','ProductController@store')->name('product.store');
    Route::get('product/{id}/edit','ProductController@edit')->name('product.edit');
    Route::post('product/update','ProductController@update')->name('product.update');
    Route::get('product/destroy/{id}','ProductController@destroy');
    Route::post('product/import','ProductController@import')->name('product.import');
    Route::get('product/export/', 'ProductController@export')->name('product.export');
});
