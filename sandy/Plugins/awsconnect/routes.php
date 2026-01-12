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

Route::get('edit', 'Controllers\AdminViewController@edit')->name('edit');
Route::post('post', 'Controllers\AdminViewController@post')->name('edit-post');
Route::post('test-con', 'Controllers\AdminViewController@testCon')->name('test-con');