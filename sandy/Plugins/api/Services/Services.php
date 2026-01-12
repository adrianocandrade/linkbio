<?php

namespace Sandy\Plugins\api\Services;
use Illuminate\Support\ServiceProvider;
use Route;

class Services extends ServiceProvider{
    public function boot(){
        // Admin Menu

    }
    public function register(){
        Route::matched(function(){
            $menu = ['url' => route('sandy-plugins-api-admin-api'), 'icon' => 'sio network-icon-043-data-management', 'name' => __('Api'), 'a-attr' => 'app-sandy-prevent=""'];

            $GLOBALS['adminMenu']['api'] = $menu;
        });
    	// Admin Menu
    }
}