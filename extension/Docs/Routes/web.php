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


// Docs Route
Route::prefix('docs')->name('docs-')->group(function(){
    Route::get('/', 'DocsController@index')->name('index');

    // Single Guide
    Route::get('guide/{slug}', 'DocsController@guide')->name('guide');
    // Docs Guides
    Route::get('guides/{id}', 'DocsController@guides')->name('guides');
});


// Admin
Route::prefix('admin/docs')->name('admin-docs-')->middleware(['is_admin'])->namespace('Admin')->group(function(){
    Route::get('/', 'AdminController@index')->name('index');

    // Add Docs
    Route::get('create', 'AdminController@create')->name('create');
    Route::post('create', 'AdminController@createPost')->name('create');

    // Edit Docs
    Route::get('edit/{id}', 'AdminController@edit')->name('edit');
    Route::post('edit/{id}', 'AdminController@editPost')->name('edit');

    // Delete
    Route::post('delete/{id}', 'AdminController@delete')->name('delete');

    // View Docs
    Route::group(['prefix' => '{id}'], function(){
        Route::get('/', 'AdminController@view')->name('view');

        // 
        Route::get('create', 'GuideController@create')->name('guide-create');
        Route::post('create', 'GuideController@createPost')->name('guide-create-post');

        // Edit guide
        Route::get('edit/{guide_id}', 'GuideController@edit')->name('guide-edit');
        Route::post('edit/{guide_id}', 'GuideController@editPost')->name('guide-edit-post');

        // Delete
        Route::post('delete/{guide_id}', 'GuideController@delete')->name('guide-delete');
    });
});



Route::prefix('support')->name('user-support-')->middleware(['auth'])->namespace('Support')->group(function(){
    // My Requests
    Route::get('/', 'MyRequestController@view')->name('my-requests');
    // Create Support
    Route::get('create', 'CreateController@view')->name('create');
    Route::post('create', 'CreateController@post')->name('create');

    // View Support
    Route::get('view/{id}', 'ViewController@view')->name('view');
    Route::get('get-messages/{id}', 'ViewController@get_messages')->name('get-messages');

    // Support response
    Route::post('respond', 'RespondController@respond')->name('respond');
});



Route::prefix('admin/inbox')->name('admin-support-')->middleware(['auth', 'is_admin'])->namespace('Support\Admin')->group(function(){
    // My Requests
    Route::get('/', 'RequestController@view')->name('requests');

    // View Support
    Route::get('view/{id}', 'ViewController@view')->name('view');
    Route::get('get-messages/{id}', 'ViewController@get_messages')->name('get-messages');

    // Support response
    Route::post('respond', 'RespondController@respond')->name('respond');
    Route::post('close-conversation/{id}', 'RespondController@close')->name('close');
});


