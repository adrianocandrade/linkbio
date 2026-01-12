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
        Route::get('/', 'CourseController@index')->name('dashboard');

        // Add New
        Route::get('new', 'NewController@new')->name('new-course');
        Route::post('new/post', 'NewController@post')->name('new-course-post');

        // Edit
        Route::get('{id}/edit', 'EditController@edit')->name('edit-course');
        Route::post('{id}/edit/post', 'EditController@post')->name('edit-course-post');

        // Delete
        Route::post('{id}/delete', 'EditController@delete')->name('delete');

        // Sales
        Route::get('sales', 'SalesController@sales')->name('sales');

        // View
        Route::get('view/{id}', 'ViewController@view')->name('view');

        // Lesson
        Route::get('{id}/lessons', 'LessonController@lesson')->name('lessons');
        // Lesson
        Route::post('{id}/lesson/sort', 'LessonController@lesson_sort')->name('lessons-sort');

        // Lesson Types
        Route::get('{id}/lesson/{type}', 'LessonController@lesson_types')->name('lesson-types');
        Route::post('{id}/lesson/{type}', 'LessonController@post')->name('lesson-post');
        // Edit Lesson Types
        Route::get('lesson-edit/{id}', 'EditLessonController@edit')->name('edit-lesson');
        Route::post('lesson-edit/{id}', 'EditLessonController@post')->name('edit-lesson-post');

        // Delete Lesson
        Route::post('lesson-delete/{id}', 'EditLessonController@delete')->name('lesson-delete');
        
        // Settings
        Route::get('settings', 'SettingsController@settings')->name('settings');
        Route::post('settings/post', 'SettingsController@setting_post')->name('settings-post');
    });
});


// Delete
Route::post('delete/{id}', 'Controllers\DeleteController@delete')->name('delete');
Route::get('/go', 'Controllers\ReturnController@return')->name('edit');
// Create Block
Route::post('create-block', 'Controllers\PostController@post_new_block')->name('create-block');