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
    Route::get('/', 'ShopController@shop')->name('home');
    Route::prefix('bag')->namespace('Cart')->name('cart-')->group(function(){
        Route::get('/', 'CartController@cart')->name('get');
        Route::post('add-cart', 'CartController@add_item')->name('add-item');
        Route::post('remove-cart', 'CartController@remove_item')->name('remove-item');

        Route::post('checkout', 'CheckoutController@checkout')->name('checkout');
        Route::get('checkout/callback', 'CheckoutController@callback')->name('callback');
    });
    

    // Single Product
    Route::get('{id}', 'ProductController@single')->name('single-product');
    Route::post('{id}/review', 'ProductController@post_review')->name('review');
});