<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Route, Artisan;
use Illuminate\Translation\TranslationServiceProvider as ServiceProvider;

class ExtendedTranslationServiceProvider extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register(){
        $this->registerLoader();
        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app['config']['app.locale'];
            $trans = new \App\ExtendedTranslator($loader, $locale);
            return $trans;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

    }
}
