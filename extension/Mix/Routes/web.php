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


Route::group(['middleware' => ['auth', 'needActivation'], 'prefix' => 'mix'], function(){
    Route::get('/', 'MixController@index')->name('user-mix');
    //Route::get('tip-collections', 'TipController@index')->name('user-mix-tips');

    // Workspaces
    Route::group(['prefix' => 'workspace'], function(){
        Route::get('create', 'WorkspaceController@create')->name('workspace-create');
        Route::post('store', 'WorkspaceController@store')
            ->middleware('throttle:5,1') // ✅ Rate limiting: 5 tentativas por minuto
            ->name('workspace-store');
        Route::get('edit/{id}', 'WorkspaceController@edit')->name('workspace-edit');
        Route::post('update/{id}', 'WorkspaceController@update')
            ->middleware('throttle:10,1') // ✅ Rate limiting: 10 tentativas por minuto
            ->name('workspace-update');
        Route::post('delete/{id}', 'WorkspaceController@delete')
            ->middleware('throttle:3,1') // ✅ Rate limiting: 3 tentativas por minuto (ação crítica)
            ->name('workspace-delete');
        Route::get('switch/{id}', 'WorkspaceController@switch')->name('workspace-switch');
    });

    Route::get('no-plan', 'Plans\NoPlanController@index')->name('user-mix-no-plan');

    Route::prefix('onboard')->name('user-mix-onboard-')->group(function(){
        Route::get('wizard', 'Onboard\OnboardingController@wizard')->name('wizard');
    });

    Route::prefix('shorten')->group(function(){
        Route::get('/', 'Shorten\ShortenController@index')->name('user-mix-shorten');
        Route::post('post', 'Shorten\ShortenController@shorten')->name('user-mix-shorten-post');
    });

    // Hightlights
    Route::prefix('highlights')->name('user-mix-highlight-')->group(function(){
        // New
        Route::get('create', 'Highlight\CreateController@create')->name('create');
        Route::post('create', 'Highlight\CreateController@createPost')->name('create-post');

        //Edit
        Route::get('{id}', 'Highlight\EditController@edit')->name('edit');
        Route::post('{id}/post', 'Highlight\EditController@editPost')->name('edit-post');

        // Delete
        Route::post('{id}/delete', 'Highlight\DeleteController@delete')->name('delete');
    });


    // Audience
    Route::prefix('audience')->namespace('Audience')->name('user-mix-audience-')->group(function(){
        Route::get('/', 'AudienceController@index')->name('index');
        Route::get('{id}', 'AudienceController@show')->name('contact');
    });


    Route::prefix('membership')->namespace('Membership')->name('user-mix-membership-')->group(function(){
        Route::get('/', 'MembershipController@index')->name('index');
        Route::get('create', 'MembershipController@create')->name('create');
        Route::post('store', 'MembershipController@store')->name('store');
        Route::get('edit/{id}', 'MembershipController@edit')->name('edit');
        Route::post('update/{id}', 'MembershipController@update')->name('update');
        Route::get('{id}/subscribers', 'SubscriptionController@index')->name('subscribers');
        Route::post('delete/{id}', 'MembershipController@destroy')->name('delete');
    });


    // Account Routes (Global - User Level)
    Route::group(['prefix' => 'account'], function(){
        Route::get('/', 'AccountController@index')->name('user-mix-account');
        Route::get('profile', 'AccountController@profile')->name('user-mix-account-profile');
        Route::post('profile/post', 'AccountController@profilePost')->name('user-mix-account-profile-post');
        Route::get('method', 'AccountController@method')->name('user-mix-account-method');
        Route::get('plan-history', 'AccountController@planHistory')->name('user-mix-account-plan-history');
        Route::get('activities', 'AccountController@authactivity')->name('user-mix-account-activities');
        Route::get('password', 'AccountController@password')->name('user-mix-account-password');
        Route::post('password/post', 'AccountController@passwordPost')->name('user-mix-account-password-post');
        
        // Security 2FA
        Route::get('security', 'Account\SecurityController@index')->name('user-mix-account-security');
        Route::post('security/enable', 'Account\SecurityController@enable')->name('user-mix-account-security-enable');
        Route::post('security/disable', 'Account\SecurityController@disable')->name('user-mix-account-security-disable');

        Route::post('delete-account', 'AccountController@deleteAccount')->name('user-mix-account-delete');
    });

    // Settings Route (Workspace Level)
    Route::group(['prefix' => 'settings'], function(){
        Route::get('/', 'SettingsController@index')->name('user-mix-settings');
        
        // Delete Account
        Route::post('delete-account', 'SettingsController@deleteAccount')->name('user-mix-settings-delete-account');

        // Settings Customizer
        Route::get('customize', 'SettingsController@customize')->name('user-mix-settings-customize');

        // Settings Social
        Route::get('social', 'SettingsController@social')->name('user-mix-settings-social');

        // Settings Profile
        Route::get('profile', 'SettingsController@profile')->name('user-mix-settings-profile');

        // Settings password
        Route::get('password', 'SettingsController@password')->name('user-mix-settings-password');

        // Settings Activity
        Route::get('activities', 'SettingsController@authactivity')->name('user-mix-settings-activity');

        // Settings Pixel's
        Route::get('pixels', 'SettingsController@pixels')->name('user-mix-settings-pixels');
        Route::post('pixels/post/{type}', 'SettingsController@pixelsPost')->name('user-mix-settings-pixels-post');

        // Domain
        Route::get('domain', 'SettingsController@domains')->name('user-mix-settings-domain');
        Route::post('domain/configure', 'SettingsController@domainConfigure')->name('user-mix-settings-domain-configure');
        Route::post('domain/set', 'SettingsController@domainSet')->name('user-mix-settings-domain-set');

        // Api
        Route::get('api', 'SettingsController@api')->name('user-mix-settings-api');
        Route::post('reset-api', 'SettingsController@resetApi')->name('user-mix-settings-api-reset');

        // Theme
        Route::get('theme', 'SettingsController@theme')->name('user-mix-settings-theme');
        Route::post('theme/post', 'SettingsController@themePost')->name('user-mix-settings-theme-post');

        // Plan History
        Route::get('plan-history', 'SettingsController@planHistory')->name('user-mix-settings-plan-history');
        Route::get('pending-plan', 'SettingsController@pendingPlan')->name('user-mix-settings-pending');


        // Settings Seo
        Route::get('seo', 'SettingsController@seo')->name('user-mix-settings-seo');
        Route::get('seo/remove-graph-image', 'SettingsController@seoRemoveGraphImage')->name('user-mix-settings-seo-remove-opengraph');

        // Payment method's
        Route::get('method', 'SettingsController@method')->name('user-mix-settings-methods');

        // Pwa
        Route::get('pwa', 'Settings\PwaController@pwa')->name('user-mix-settings-pwa');
        Route::post('pwa-post', 'Settings\PwaController@pwa_post')->name('user-mix-settings-pwa-post');
        Route::post('push', 'Settings\PwaController@push')->name('user-mix-settings-pwa-push');


        Route::name('user-mix-settings-integrations-')->prefix('integrations')->namespace('Integrations')->group(function() {
            Route::get('/', 'IntegrationsController@index')->name('all');

            // Tidio
            Route::get('tidio', 'Tidio\TidioController@index')->name('tidio');
            Route::post('tidio-post', 'Tidio\TidioController@post')->name('tidio-post');
        });

        // Post Settings
        Route::post('post/{type}', 'SettingsController@post')->name('user-mix-settings-post');
    });

    // Plan
    Route::group(['prefix' => 'plan/{id}'], function(){
        Route::get('/', 'PlanController@purchase')->name('user-mix-purchase-plan');

        // Invoice
        Route::get('invoice', 'PlanController@invoice')->name('user-mix-plan-invoice');

        // Init Payment
        Route::post('payment', 'PlanController@payment')->name('user-mix-plan-payment-post');

        // Activate plan
        Route::get('activate/{sxref}', 'PlanController@activate')->name('user-mix-activate-plan');

        // Activate Free
        Route::post('free/activate', 'PlanController@activateFree')->name('user-mix-activate-plan-free');
        // ACtivate Trial
        Route::post('trial/activate', 'PlanController@activateTrial')->name('user-mix-activate-plan-trial');
    });

    // Analytics
    Route::group(['prefix' => 'analytics'], function(){
        Route::get('/', 'AnalyticsController@insight')->name('user-mix-analytics');

        // Views
        Route::get('views', 'AnalyticsController@views')->name('user-mix-analytics-views');
        Route::get('live', 'AnalyticsController@live')->name('user-mix-analytics-live');
        Route::get('links', 'AnalyticsController@links')->name('user-mix-analytics-links');
        Route::get('links/{slug}', 'AnalyticsController@link')->name('user-mix-analytics-link');
    });

    // Add Section
    Route::group(['prefix' => 'app'], function(){
        Route::get('/', 'AppsController@add')->name('user-mix-apps');

        // New Section
        Route::group(['prefix' => '{slug}'], function(){
             Route::get('/', 'AppsController@section_link')->name('user-mix-app-new');

             // Preview
             Route::get('view', 'AppsController@preview_section')->name('user-mix-app-preview');
        });

        // Post Section
        Route::post('post', 'AppsController@post')->name('user-mix-app-post');
    });

    // Pages

    Route::group(['prefix' => 'pages', 'namespace' => 'Elements'], function(){
        Route::get('/', 'ElementController@all')->name('user-mix-pages');

        // Add new page

        // Preview page
        Route::get('view/{element}', 'ElementController@preview_section')->name('user-mix-element-preview');

        // Tree
        Route::get('tree/{slug}', 'ElementController@elementTree')->name('user-mix-element-tree');
    });


    // Blocks
    Route::group(['namespace' => 'Blocks', 'prefix' => 'blocks'], function(){
        // New Block
        Route::get('/', 'BlockController@blocks')->name('user-mix-block-new');

        Route::post('sort', 'BlockController@sort')->name('user-mix-block-sort');

        // Post Block
        Route::post('block/element/{block}', 'CreateController@post')->name('user-mix-block-element-post');
        //
        Route::post('element/{id}', 'CreateController@edit')->name('user-mix-block-element-edit');
        //
        Route::post('element/{id}/new', 'CreateController@newElement')->name('user-mix-block-element-new');


        Route::post('block/{id}/edit', 'EditController@editBlock')->name('user-mix-block-edit');
        Route::post('request-linktree', 'LinktreeController@copy')->name('user-mix-copy-linktree');

        Route::get('edit-block/{id}', 'BlockController@edit_block_get')->name('user-mix-block-edit-get');
    });
});
