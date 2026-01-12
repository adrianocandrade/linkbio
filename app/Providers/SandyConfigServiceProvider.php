<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SandyConfigServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        config([
            'filesystems.disks.local.url' => url('/'),
        ]);

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}