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

Route::get('edit/{slug}', 'Controllers\EditController@edit')->name('edit');
Route::post('edit/{slug}', 'Controllers\EditController@editPost')->name('edit');

Route::get('export/{slug}', 'Controllers\ExportController@export')->name('export');

// New

Route::get('new', 'Controllers\NewController@new')->name('create');
Route::post('new', 'Controllers\NewController@create')->name('create');
// Database
Route::get('database/{slug}', 'Controllers\DatabaseController@database')->name('database');

// Delete
Route::post('delete/{slug}', 'Controllers\DeleteController@delete')->name('delete');

// Render it
Route::get('view/{slug}', 'Controllers\RenderController@render')->name('render');

Route::post('list/{slug}', 'Controllers\RenderController@postSubmission')->name('post-submission');