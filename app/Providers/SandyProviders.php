<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Route, Artisan;

class SandyProviders extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register(){
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){
        if (!is_installed()) {
            return false;
        }
        $this->app->register("Modules\Docs\Providers\DocsServiceProvider");
        
        $this->app->register("App\Providers\RegisterSandyExtension");
        $this->app->register("Modules\Index\Providers\IndexServiceProvider");
        $this->app->register("Modules\Mix\Providers\MixServiceProvider");
        $this->app->register("App\Providers\RouteServiceProvider");
        $this->app->register("App\Providers\MultiDomainProvider");
        $this->app->register("App\Providers\ExtendedTranslationServiceProvider");


        
        $this->app->register("Modules\Bio\Providers\ExtenedServiceProvider");
    }
}
