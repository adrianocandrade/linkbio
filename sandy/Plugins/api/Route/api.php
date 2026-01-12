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

// Init Api Routes
Route::prefix('v1')->namespace('Controllers\Api')->group(function(){

	Route::middleware('user-api')->group(function(){
		Route::get('/', function(){
	        $response = [
	            'status' => true,
	           	'message' => 'Api Connected Successfully'
	        ];

	        return \Response::json($response);
		})->name('index');

		Route::get('user', 'UserController@retrieve')->name('retrieve-user');

		// Blocks
		Route::get('blocks', 'BlockController@retrieve')->name('retrieve-blocks');
		Route::get('blocks/{block_id}', 'BlockController@single')->name('retrieve-single-block');

		// Analytics
		Route::prefix('analytics')->group(function(){
			// Live
			Route::get('live', 'AnalyticsController@live')->name('retrieve-analytics-live');

			// Views
			Route::get('views', 'AnalyticsController@views')->name('retrieve-analytics-views');

			// Clicks
			Route::get('clicks', 'AnalyticsController@clicks')->name('retrieve-analytics-clicks');
			Route::get('clicks/{slug}', 'AnalyticsController@single_click')->name('retrieve-analytics-single-click');
		});


		Route::prefix('pixels')->group(function(){
			// Pixels
			Route::get('/', 'PixelController@pixels')->name('retrieve-pixels');

			// Add new
			Route::post('/', 'PixelController@new')->name('post-pixels');
			// Template
			Route::get('template', 'PixelController@template')->name('retrieve-pixels-template');

			// View & edit pixels
			Route::get('{id}', 'PixelController@pixel')->name('view-pixels');
			Route::post('{id}', 'PixelController@editPixel')->name('edit-pixels');
			Route::post('{id}/delete', 'PixelController@delete')->name('delete-pixels');
		});

		// Plan History

		Route::get('plan-history', 'PlanController@history')->name('retrieve-plan-history');


		// Activity Log
		Route::get('activities', 'UserController@activities')->name('retrieve-activities');

		// Audience
		Route::prefix('audience')->group(function(){
            Route::get('contacts', 'AudienceController@retrieve')->name('retrieve-contacts');
            Route::get('contacts/{id}', 'AudienceController@single')->name('retrieve-single-contact');
        });

        // Membership
		Route::prefix('membership')->group(function(){
            Route::get('plans', 'MembershipController@retrieve')->name('retrieve-membership-plans');
            Route::get('plans/{id}', 'MembershipController@single')->name('retrieve-single-membership-plan');
        });
	});

	Route::middleware('admin-api')->namespace('Admin')->prefix('admin')->name('admin-')->group(function(){
		Route::get('/', function(){
	        $response = [
	            'status' => true,
	           	'message' => 'Api Connected Successfully'
	        ];

	        return \Response::json($response);
		})->name('index');



		// Users
		Route::prefix('users')->group(function(){
			Route::get('/', 'UsersController@all')->name('retrieve-users');
			Route::get('retrieve/{user_id}', 'UsersController@singleUser')->name('retrieve-single-users');

			Route::post('update/{user_id}', 'UsersController@update')->name('update-users');
			Route::post('new-user', 'UsersController@newUser')->name('create-new-user');
			Route::post('delete/{user_id}', 'UsersController@delete')->name('delete-user');
		});

		// Plan

		Route::prefix('plans')->group(function(){
			Route::get('/', 'PlansController@plans')->name('retrieve-plans');
			Route::get('single/{id}', 'PlansController@plan')->name('retrieve-plan');
			Route::post('add/{id}', 'PlansController@AddPlanToUser')->name('add-plan-user');
		});

		// Plan Payments
		Route::prefix('payments')->group(function(){
			Route::get('/', 'PaymentsController@payments')->name('retrieve-payments');
			Route::get('single/{id}', 'PaymentsController@payment')->name('retrieve-payment');
		});
	});
});