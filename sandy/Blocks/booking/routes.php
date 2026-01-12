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



// Courses
Route::name('mix-')->namespace('Controllers\Mix')->group(function(){
    // Course Setup
    Route::middleware([])->group(function(){
        Route::get('/', 'DashboardController@dashboard')->name('dashboard');
        Route::get('calendar', 'DashboardController@calendar')->name('calendar');
        Route::get('calendar/{booking_id}', 'DashboardController@calendar_view')->name('calendar-view');
        Route::post('booking-status', 'DashboardController@change_booking_status')->name('change-booking-status');


        Route::get('settings', 'DashboardController@settings')->name('settings');

        // Settings
        //Route::get('settings', 'SettingsController@settings')->name('settings');
        Route::post('settings/post', 'SettingsController@setting_post')->name('settings-post');
        Route::post('settings/tree/{tree}', 'SettingsController@tree')->name('settings-tree');
    });
});


// Delete
Route::post('delete/{id}', 'Controllers\DeleteController@delete')->name('delete');
Route::get('/go', 'Controllers\ReturnController@return')->name('edit');
// Create Block
Route::post('create-block', 'Controllers\PostController@post_new_block')->name('create-block');