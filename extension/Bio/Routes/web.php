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


Route::group([], function(){
    // Bio Link
    Route::get('/', 'BioController@bio')->name('home');
    Route::post('dark-mode', 'BioController@dark_mode')->name('dark-mode');


    // Sandy Manifest 
    Route::get('manifest.json', 'Pwa\SandyPwaController@manifest')
        ->name('sandy-manifest');


    // Add device Token
    Route::post('save-token', 'Notification\NotificationController@save_token')->name('save-notification-token');
});