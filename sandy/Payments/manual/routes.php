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

Route::get('create', 'Controllers\BankController@create')->name('create');
Route::post('post', 'Controllers\BankController@post')->name('pending-create');
Route::post('delete/{id}', 'Controllers\BankController@delete')->name('pending-delete');
// Edit User Route
//Route::get('user/edit', 'Controllers\EditUserController@edit')->name('user-edit');
// Edit admin
Route::get('admin/edit', 'Controllers\EditAdminController@edit')->name('admin-edit');