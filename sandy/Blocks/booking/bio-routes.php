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


Route::namespace('Controllers\Bio')->group(function(){
    Route::get('/', 'BookingController@index')->name('booking');

    Route::get('validate-booking', 'BookingController@validate_booking')->name('validate-booking');
    Route::get('success', 'BookingController@success')->name('success');

    
    Route::get('bookings', 'BookingsController@bookings')->middleware(['auth'])->name('bookings');
    Route::get('bookings/{booking_id}', 'BookingsController@view')->middleware(['auth'])->name('booking-view');
});