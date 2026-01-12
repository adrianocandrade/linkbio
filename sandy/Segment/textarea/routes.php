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

Route::get('edit/{slug}', 'Controllers\User\EditController@edit')->name('edit');
Route::post('edit/{slug}', 'Controllers\User\EditController@editPost')->name('edit');

// Create textarea
Route::get('create', 'Controllers\User\CreateController@create')->name('create');
Route::post('create', 'Controllers\User\CreateController@createPost')->name('create');

// Render
Route::get('{slug}', 'Controllers\RenderController@render')->name('render');