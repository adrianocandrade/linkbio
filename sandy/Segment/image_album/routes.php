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
Route::post('edit/{slug}/add-images', 'Controllers\User\EditController@addImages')->name('add-images');
Route::post('edit/{slug}/sort-images', 'Controllers\User\EditController@sortImages')->name('sort-images');
Route::post('delete/{slug}/delete-images', 'Controllers\User\EditController@deleteImages')->name('delete-images');

// Delete
Route::post('delete/{slug}', 'Controllers\User\DeleteController@delete')->name('delete');

// Create
Route::get('create', 'Controllers\User\CreateController@create')->name('create');
Route::post('create', 'Controllers\User\CreateController@createPost')->name('create');

// Render
Route::get('{slug}', 'Controllers\RenderController@render')->name('render');