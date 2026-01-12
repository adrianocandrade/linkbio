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

Route::get('create', 'Controllers\StripeController@create')->name('create');
Route::get('verify', 'Controllers\StripeController@verify')->name('verify');
// Edit User Route
Route::get('user/edit', 'Controllers\EditUserController@edit')->name('user-edit');
// Edit admin
Route::get('admin/edit', 'Controllers\EditAdminController@edit')->name('admin-edit');