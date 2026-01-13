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

Route::prefix('admin')->middleware(['auth', 'is_admin'])->name('admin-')->group(function(){
    Route::get('/', 'AdminController@index')->name('dashboard');

    // Temporary fix for users without default workspace
    Route::get('fix-workspaces', function(){
        $users = \App\User::all();
        $count = 0;
        foreach($users as $user){
            // Check if user has any workspace
            $hasWorkspace = \App\Models\Workspace::where('user_id', $user->id)->exists();
            
            if(!$hasWorkspace){
                // Create Default Workspace
                \App\Models\Workspace::create([
                    'user_id' => $user->id,
                    'name' => 'My Workspace',
                    'is_default' => 1,
                    'status' => 1
                ]);
                $count++;
            }
        }
        return "Fixed {$count} users without workspaces.";
    })->name('fix-workspaces');

    // Users
    Route::prefix('users')->group(function(){
        // All Users
        Route::get('/', 'UsersController@all')->name('users');

        // New User
        Route::post('new-user', 'UsersController@newUser')->name('new-user');
        // Login as user
        Route::post('login/{id}', 'Users\LoginAsController@login')->name('users-login');
        // Export as csv
        Route::get('export-csv', 'Users\ExportController@export_as_csv')->name('users-export-csv');

        Route::post('delete/{id}', 'Users\EditUserController@deleteUser')->name('delete-user');
        // Edit User
        Route::get('{id}', 'Users\EditUserController@edit')->name('edit-user');
        Route::post('{id}/post', 'Users\EditUserController@editPost')->name('edit-user-post');
    });

    // Deleted Users / Backups
    Route::prefix('deleted-users')->namespace('Users')->name('deleted-users-')->group(function(){
        Route::get('/', 'DeletedUsersController@index')->name('index');
        Route::get('{id}', 'DeletedUsersController@show')->name('show');
        Route::post('{id}/restore', 'DeletedUsersController@restore')->name('restore');
        Route::get('{id}/download', 'DeletedUsersController@download')->name('download');
        Route::post('{id}/delete', 'DeletedUsersController@delete')->name('delete');
    });

    // Plans
    Route::prefix('plans')->group(function(){
        Route::get('/', 'Plans\PlanController@plans')->name('plans');

        // Add new plan
        Route::get('new', 'Plans\PlanController@new')->name('new-plan');
        Route::post('new/post', 'Plans\PlanController@newPost')->name('new-plan-post');

        // Edit Plan
        Route::get('edit/{id}', 'Plans\PlanController@edit')->name('edit-plan');
        Route::post('edit/{id}/post', 'Plans\PlanController@editPost')->name('edit-plan-post');

        // Sort
        Route::post('sort', 'Plans\PlanController@sort')->name('plans-sort');
        Route::post('delete/{id}', 'Plans\PlanController@delete')->name('plans-delete');

        //
        Route::post('add-to-user', 'Plans\PlanController@AddToUser')->name('plans-add-to-user');
    });

    // Translation
    Route::prefix('languages')->group(function(){
        Route::get('/', 'TranslationController@languages')->name('languages');

        // View Translation
        Route::get('view/{lang}', 'TranslationController@viewLang')->name('view-translation');

        // Post translation
        Route::post('post/trans/{type}/{language}', 'TranslationController@postTrans')->name('post-translation');

        // Delete language 
        Route::get('delete/{lang}', 'TranslationController@deleteLanguage')->name('delete-language');

        // Duplicate language 
        Route::get('duplicate/{lang}', 'TranslationController@duplicateLanguage')->name('duplicate-language');

        // New language 
        Route::post('new', 'TranslationController@newLanguage')->name('new-language');
    });
  
  	// Pages
    Route::prefix('page')->group(function(){
        Route::get('/', 'PageController@pages')->name('pages');

        // Add new Page
        Route::get('new', 'PageController@new')->name('new-page');
        Route::post('new/post', 'PageController@newPage')->name('new-page-post');


        // Edit Page
        Route::get('edit/{id}', 'PageController@edit')->name('edit-page');
        Route::post('edit/{id}/post', 'PageController@editPage')->name('edit-page-post');

        // Delete

        Route::get('delete/{id}', 'PageController@delete')->name('delete-page');

        // Sortable
        Route::post('sort', 'PageController@sort')->name('sort-page');
    });

    // Blog 
    Route::prefix('blog')->group(function(){
        Route::get('/', 'BlogController@blogs')->name('blogs');

        // Add new Blog
        Route::get('new', 'BlogController@new')->name('new-blog');
        Route::post('new/post', 'BlogController@newPost')->name('new-blog-post');


        // Edit blog
        Route::get('edit/{id}', 'BlogController@edit')->name('edit-blog');
        Route::post('edit/{id}/post', 'BlogController@editPost')->name('edit-blog-post');

        // Delete

        Route::get('delete/{id}', 'BlogController@delete')->name('delete-blog');

        // Sortable
        Route::post('sort', 'BlogController@sort')->name('sort-blog');
    });

    // Analytics
    Route::prefix('analytics')->group(function(){
        Route::get('/', 'AnalyticsController@analytics')->name('analytics');

        // 
        Route::get('logged-in', 'AnalyticsController@loggedIn')->name('analytics-logged-in');
        //
        Route::get('most-visited', 'AnalyticsController@mostVisited')->name('analytics-most-visited');
    });

    // Error Log
    Route::prefix('error-log')->group(function(){
        Route::get('/', 'Errors\ErrorLogController@log')->name('error-logs');
    });

    // Plugins

    Route::prefix('plugins')->group(function(){
        // Types of available plugins
        Route::get('/', 'PluginsController@types')->name('plugins-types');
        // Bio Elements
        Route::get('elements', 'Plugins\ElementsController@elements')->name('bio-elements');
        Route::get('elements/make-public', 'Plugins\ElementsController@make_all_public')->name('bio-elements-make-all-public');
        // Configue Element


        Route::prefix('elements/configure')->group(function(){
            Route::get('{element}', 'Plugins\ElementsController@configure')->name('bio-elements-configure');
            Route::post('{element}/post', 'Plugins\ElementsController@configure_post')->name('bio-elements-configure-post');


            // Gallery
            Route::post('upload-gallery/{element}', 'Plugins\Elements\MediaController@uploadGallery')->name('bio-elements-gallery-upload');
            Route::post('delete-gallery/{element}/{media}', 'Plugins\Elements\MediaController@deleteGallery')->name('bio-elements-gallery-delete');

            // Assets
            Route::post('upload-assets/{element}', 'Plugins\Elements\MediaController@uploadAssets')->name('bio-elements-assets-upload');
            Route::post('delete-assets/{element}/{media}', 'Plugins\Elements\MediaController@deleteAssets')->name('bio-elements-assets-delete');

            //

            Route::get('make-public/{element}', 'Plugins\Elements\MediaController@makePublic')->name('bio-elements-make-public');

            Route::post('sort-gallery/{element}', 'Plugins\Elements\MediaController@sortGallery')->name('bio-elements-configure-sort-gallery');
        });

        // Upload Element
        Route::post('element/upload', 'Plugins\ElementsController@elementsPost')->name('bio-elements-upload');
        Route::post('element/delete', 'Plugins\ElementsController@delete')->name('bio-elements-delete');

        // General
        Route::get('general', 'Plugins\GeneralController@general')->name('general-plugins');
        Route::post('general/upload', 'Plugins\GeneralController@pluginsUpload')->name('plugins-upload');
        Route::post('general/delete', 'Plugins\GeneralController@delete')->name('plugins-delete');



        // General
        Route::get('payments', 'Plugins\PaymentsController@payments')->name('payments-plugins');
        Route::post('payments/upload', 'Plugins\PaymentsController@paymentsUpload')->name('payments-plugins-upload');
        // Delete Payment method
        Route::post('payments/delete', 'Plugins\PaymentsController@delete')->name('payments-plugins-delete');
    });

    // Payments
    Route::prefix('payments')->group(function(){
        Route::get('/', 'PaymentController@payments')->name('payments');

        // Pending Payments
        Route::get('pending', 'PaymentController@pending')->name('payments-pending');
        //
        Route::post('pending-post/{type}', 'PaymentController@pendingPost')->name('payments-pending-post');
    });
    // License





    // Domain
    Route::prefix('domain')->namespace('Domain')->name('domain-')->group(function(){
        Route::get('/', 'DomainController@all')->name('all');
        Route::post('post/{type}', 'DomainController@post')->name('post');
    });

    // Settings
    Route::prefix('settings')->group(function(){
        Route::get('/', 'SettingsController@settings')->name('settings');
        Route::get('htaccess/{type}', 'SettingsController@updatehtaccess')->name('settings-htaccess');

        Route::post('post', 'SettingsController@post')->name('settings-post');
    });
});

Route::get('admin/return-to-admin', 'Users\LoginAsController@returnToAdmin')
    ->middleware('auth')
    ->name('return-to-admin');