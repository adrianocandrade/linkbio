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

// Textarea
Route::get('/', 'Controllers\NewController@textarea')->name('skel');
Route::post('post/new', 'Controllers\NewController@PostNew')->name('post-new');

// Edit
Route::get('{id}', 'Controllers\EditController@edit')->name('edit');
Route::post('{id}/post/edit', 'Controllers\EditController@EditPost')->name('post-edit');


// Delete
Route::post('delete/{id}', 'Controllers\DeleteController@delete')->name('delete');
Route::post('create-block', 'Controllers\PostController@post_new_block')->name('create-block');