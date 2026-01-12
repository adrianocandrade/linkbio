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

Route::prefix('install')->name('install-')->middleware(['app_is_installed'])->group(function() {
    Route::get('/', 'InstallController@index')->name('index');

    // Steps
    Route::prefix('steps')->name('steps-')->group(function(){
        Route::get('database', 'DatabaseController@database')->name('database');
        Route::post('database-con', 'DatabaseController@database_save')->name('database-save');
        Route::get('database-migrate', 'DatabaseController@database_migrate')->name('database-migrate');

        // User
        Route::get('user', 'UserController@user')->name('user');
        Route::post('user/post', 'UserController@user_save')->name('user-post');

        // Finish
        Route::get('finalize', 'InstallController@finalize')->name('finalize');
    });
});