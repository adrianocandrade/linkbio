<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Route, Artisan;
use App\Models\Domain;

class MultiDomainProvider extends ServiceProvider{
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
        if ($this->app->runningInConsole()) {
            return;
        }

        $domain = $this->app->request->getHost();
        $env_domain = parse(config('app.url'), 'host');


        $domain_wildcard = preg_match("/[^\.\/]+\.[^\.\/]+$/", $domain, $matches);
        $domain_wildcard = $matches[0] ?? $domain;
        $env_wildcard = parse(config('app.BIO_WILDCARD_DOMAIN'), 'host');
        $is_wildcard = $env_wildcard == $domain_wildcard ? true : false;


        $domainModel = Domain::where('host', $domain)->first();
        if ($domain !== $env_domain && !$domainModel && !$is_wildcard && $domain !== '127.0.0.1' && $domain !== 'localhost') {
            abort(404);
        }
    }
}
