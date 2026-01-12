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

// Init Docs Api Web Routes
Route::get('docs-api', 'Controllers\ApiDocsController@api')->name('docs-api');
Route::get('api-admin', 'Controllers\AdminApiController@api')->name('admin-api');