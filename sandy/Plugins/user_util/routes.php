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

// Init Tree
Route::get('tree', 'Controllers\TreeController@tree')->name('tree');

// Soical
Route::prefix('social')->name('socials-')->group(function(){
	Route::get('/', 'Controllers\SoicalController@socials')->name('index');

	Route::get('edit/{social}', 'Controllers\SoicalController@edit')->name('edit');
	Route::post('edit/{social}/post', 'Controllers\SoicalController@editPost')->name('edit-post');
	Route::post('edit/{social}/delete', 'Controllers\SoicalController@delete')->name('delete');

	Route::post('post', 'Controllers\SoicalController@postNewSocial')->name('post');
});

// Font
Route::prefix('fonts')->name('fonts-')->group(function(){
	Route::get('/', 'Controllers\FontController@fonts')->name('index');

	Route::get('new', 'Controllers\FontController@Newfonts')->name('new');

	Route::post('post', 'Controllers\FontController@addFont')->name('post');
	Route::post('sort', 'Controllers\FontController@sortFont')->name('sort');

	Route::post('delete', 'Controllers\FontController@deleteFont')->name('delete');
});


// Theme

Route::prefix('themes')->name('themes-')->namespace('Controllers\Theme')->group(function(){
	Route::get('/', 'ThemesController@all')->name('index');
	Route::post('upload', 'ThemesController@upload')->name('upload');
	Route::post('{theme}/delete', 'ThemesController@delete')->name('delete');

	// Theme
	Route::get('{theme}', 'EditController@theme')->name('edit');

	// Theme Media
	Route::get('{theme}/make-putlic', 'MediaController@makePublic')->name('make-public');
	Route::post('{theme}/upload-media', 'MediaController@uploadMedia')->name('upload-media');
	Route::post('{theme}/delete-media/{media}', 'MediaController@deleteMedia')->name('delete-media');


	// Edit Theme
	Route::post('{theme}/edit', 'EditController@editPost')->name('edit-post');


	// Theme Css
	Route::get('{theme}/edit/{css}', 'CssController@edit')->name('edit-css');
	Route::post('{theme}/edit/{css}/post', 'CssController@editPost')->name('edit-css-post');
	Route::post('{theme}/upload-css', 'CssController@uploadCss')->name('css-upload');
	Route::post('{theme}/edit/{css}/delete', 'CssController@delete')->name('css-delete');
});