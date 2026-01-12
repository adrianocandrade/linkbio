<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use MiladRahimi\PhpCrypt\Symmetric;
use MiladRahimi\PhpCrypt\PrivateRsa;
use MiladRahimi\PhpCrypt\PublicRsa;
use Defuse\Crypto\Crypto;
use Illuminate\Support\Facades\Artisan;
use App\Sandy\Kuda\KudaOpenApi;

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


Route::group(['prefix' => 'auth'], function(){
    Route::get('/', 'Auth\AuthController@index')->name('auth-index');

    Route::post('check-username', 'Auth\RegisterController@check_username')->name('auth-check-username');

    Route::post('validate-password', 'Auth\RegisterController@validate_password')->name('auth-validate-password');

    # Register
    Route::get('register', 'Auth\RegisterController@register')->name('user-register');
    Route::post('register-post', 'Auth\RegisterController@registerPost')->name('user-register-post');

    # Login
    Route::get('login', 'Auth\LoginController@login')->name('user-login');
    Route::post('login', 'Auth\LoginController@loginPost')->name('user-login-post');

    # Reset
    Route::prefix('reset-pw')->group(function(){
        Route::get('request', 'Auth\ResetPasswordController@request')->name('user-login-reset-pw-request');
        Route::post('request/post', 'Auth\ResetPasswordController@requestPost')->name('user-login-reset-pw-request-post');

        // Reset Password
        Route::get('r/{token}', 'Auth\ResetPasswordController@reset')->name('user-login-reset-pw');
        Route::post('p/{token}', 'Auth\ResetPasswordController@resetPost')->name('user-login-reset-pw-post');
    });

    # Activation
    Route::get('activation/{token}', 'Auth\ActivationController@activate')->name('user-activate-email');
    Route::get('auth/need-activation', 'Auth\ActivationController@needActivation')->name('user-need-activate-email');

    Route::get('banned', 'Auth\ActivationController@banned')->name('user-banned');

    // Resend activation
    Route::post('resend-activation', 'Auth\ActivationController@ResendActivation')->name('user-reset-activate-email');

    # Logout
    Route::get('logout', 'Auth\LoginController@logout')->name('user-logout');


    # Social login

    // Google
    Route::prefix('google')->group(function(){
        Route::get('/', 'Auth\GoogleController@redirect')->name('user-auth-google');

        Route::get('callback', 'Auth\GoogleController@callback')->name('user-auth-google-callback');
    });


    Route::prefix('facebook')->group(function(){
        Route::get('/', 'Auth\FacebookController@redirect')->name('user-auth-facebook');
        Route::get('callback', 'Auth\FacebookController@callback')->name('user-auth-facebook-callback');
    });

    // 2FA Routes
    Route::group(['prefix' => '2fa', 'namespace' => 'Auth'], function(){
        Route::get('/', 'TwoFactorController@index')->name('2fa.index');
        Route::post('/', 'TwoFactorController@verify')->name('2fa.verify');
    });
});


Route::get('cron', 'CronController@cron')->name('sandy-cron');
Route::get('direct/{slug}', 'LinkerController@redirect')->name('linker');

Route::get('cdn', 'CdnController@cdn')->name('sandy-site-cdn');
Route::get('offline', 'OfflineController@offline')->name('site-offline');

// 
Route::get('updatedb', 'UpdateDBController@update')->name('update-database');

Route::get('firebase-messaging-sw.js', 'FirebaseMessageSWController@sw')->name('firebase-sw');