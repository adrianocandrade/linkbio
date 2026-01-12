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



// Product
Route::name('mix-')->namespace('Controllers\Mix')->group(function(){
    Route::group([], function(){
        //
        Route::get('dashboard', 'ShopController@index')->name('view');
        Route::post('sort', 'ShopController@sort')->name('sort');

        // Add Product
        Route::get('product/new', 'Product\CreateController@new')->name('new-product');
        Route::post('product/new/post', 'Product\CreateController@post')->name('new-product-post');


        // Edit Product
        Route::get('product/edit/{id}', 'Product\EditController@edit')->name('edit-product');
        Route::post('product/edit/{id}/post', 'Product\EditController@post')->name('edit-product-post');

        Route::post('product/delete/{id}', 'Product\EditController@delete')->name('delete-product');

        Route::get('product/delete-file/{id}/{file}', 'Product\EditController@delete_file')->name('delete-product-file');

        // Settings
        Route::get('settings', 'SettingsController@settings')->name('settings');
        Route::post('settings/post', 'SettingsController@setting_post')->name('settings-post');


        // Variant
        Route::post('product/variant/new', 'Product\VariantController@create')->name('create-variant');
        Route::post('product/variant/edit', 'Product\VariantController@edit')->name('edit-variant');
        Route::post('product/variant/sort', 'Product\VariantController@sort')->name('sort-variant');
        Route::get('product/variant/delete/{id}', 'Product\VariantController@delete')->name('delete-variant');


        // Shipping

        Route::prefix('shipping')->name('shipping-')->namespace('Shipping')->group(function(){
            Route::get('/', 'ShippingController@shipping')->name('index');
            Route::post('post/new', 'ShippingController@post_new')->name('post-new');
            Route::post('delete/{id}', 'ShippingController@delete')->name('delete');


            // Locations
            Route::get('locations/{id}', 'LocationsController@locations')->name('locations');
            Route::post('locations/edit', 'LocationsController@edit')->name('location-edit');
            Route::post('locations/delete/{id}', 'LocationsController@delete')->name('location-delete');
            Route::post('locations/{id}', 'LocationsController@post')->name('location-post');
        });


        // Orders
        Route::get('orders', 'Orders\OrdersController@orders')->name('orders');
        Route::get('orders/{id}', 'Orders\OrdersController@single')->name('single-order');
        Route::post('order-status/{id}/{type}', 'Orders\OrdersController@status')->name('order-status');
    });
});


// Delete
Route::post('delete/{id}', 'Controllers\DeleteController@delete')->name('delete');
Route::get('/go', 'Controllers\ReturnController@return')->name('edit');
Route::post('create-block', 'Controllers\PostController@post_new_block')->name('create-block');