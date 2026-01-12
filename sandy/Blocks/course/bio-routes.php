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
    Route::get('/', 'CatelogController@catelog')->name('home');
    Route::get('unlock', 'UnlockCourseController@unlock')->name('unlock');

    // Single Course
    Route::get('{id}', 'CoursesController@single')->name('single-course');

    // Single Course
    Route::post('{id}/pay', 'UnlockCourseController@pay')->name('pay');

    // Take Course
    Route::get('{id}/take', 'LessonController@take')->name('take-course');

    // Take Course
    Route::post('{id}/review', 'CoursesController@post_review')->name('review');
});