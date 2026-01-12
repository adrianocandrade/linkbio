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


Route::get('/', 'IndexController@index')->name('index-home');

Route::prefix('index')->name('index-')->group(function() {
    Route::post('switch-lang', 'IndexController@switchLocale')->name('switch-lang');

    Route::get('accelerated-pages', 'IndexController@apps')->name('accelerated-pages');
    Route::get('accelerated-pages/view/{element}', 'IndexController@apps_view')->name('accelerated-pages-view');
});

// Pricing Route
Route::prefix('pricing')->name('pricing-')->group(function(){
    Route::get('/', 'PricingController@pricing')->name('index');
});

// Blog's Route

Route::prefix('blog')->name('index-blog-')->group(function(){
    Route::get('/', 'BlogController@blogs')->name('all');

    // Single Blog
    Route::get('/{uri}', 'BlogController@single')->name('single');
});

Route::prefix('page')->name('index-page-')->group(function(){
    Route::get('/', function () {
    	return redirect('/');
	});

    // Single Pages
    Route::get('/{uri}', 'PageController@single')->name('single');
});

// Discover
Route::prefix('discover')->name('discover-')->group(function(){
    Route::get('/', 'DiscoverController@discover')->name('index');
});