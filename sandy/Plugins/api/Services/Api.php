<?php

namespace Sandy\Plugins\api\Services;
use Illuminate\Support\ServiceProvider;
use Route;

class Api extends ServiceProvider{
    public function boot(){
        // Admin Menu

    }
    public function register(){
        $plugin = 'api';
        $route = base_path("sandy/Plugins/$plugin/Route/api.php");

        Route::middleware('api')->prefix("api")->namespace("\Sandy\Plugins\\" . $plugin)->name("sandy-api-")->group($route);

        
    }
}