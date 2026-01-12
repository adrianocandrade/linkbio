<?php

namespace Sandy\Plugins\awsconnect\Services;
use Illuminate\Support\ServiceProvider;
use Route;

class Services extends ServiceProvider{
    public function boot(){
        // Admin Menu

    }
    public function register(){
        Route::matched(function(){
            $menu = ['url' => route('sandy-plugins-awsconnect-edit'), 'icon' => 'sio technology-flaticon-070-cloud-storage', 'name' => __('Aws Connect')];

            $GLOBALS['adminMenu']['aws'] = $menu;
        });
    	// Admin Menu
    }
}