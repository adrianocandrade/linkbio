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

// Route::post('retrieve-link', 'Controllers\NewController@retrieve')->name('retrieve');

// Delete
Route::post('delete/{id}', 'Controllers\DeleteController@delete')->name('delete');
Route::post('create-block', 'Controllers\PostController@post_new_block')->name('create-block');