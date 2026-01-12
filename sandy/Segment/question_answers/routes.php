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
Route::post('respond/{slug}', 'Controllers\User\EditController@respond')->name('user-respond');

// Database
Route::get('database/{slug}', 'Controllers\User\DatabaseController@database')->name('database');

// Delete
Route::post('delete/{slug}', 'Controllers\User\DeleteController@delete')->name('delete');

// Create
Route::get('create', 'Controllers\User\CreateController@create')->name('create');
Route::post('create', 'Controllers\User\CreateController@createPost')->name('create');

// Render
Route::get('{slug}', 'Controllers\RenderController@render')->name('render');

// Send Message
Route::post('{slug}/message', 'Controllers\RenderController@ask')->name('ask');

Route::post('{slug}/pay', 'Controllers\RenderController@pay_to_ask')->name('pay');
Route::get('{slug}/paid', 'Controllers\RenderController@pay_callback')->name('pay-callback');

Route::post('{slug}/paid/message', 'Controllers\RenderController@paid_question_ask')->name('paid-question-ask');