<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Route, Artisan;

class RegisterSandyExtension extends ServiceProvider{
    /**
     * Register any application services.
     *
     * @return void
     */

    public function register(){
        // Register plugins
        $this->plugins();

        // Register Bio
        $this->bio();

        // Payments
        $this->payments();

        // Blocks
        $this->blocks();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(){

    }


    public function blocks(){
        $directory = new \DirectoryIterator(base_path('sandy/Blocks'));
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $method = $info->getFilename();
                $path = $info->getPathname();

                // Route Path
                $routes = "{$path}/routes.php";

                // Register services

                if (is_dir($servicePath = base_path("sandy/Blocks/$method/Services"))) {
                    $services = new \DirectoryIterator($servicePath);

                    // Loop services folder
                    foreach ($services as $service) {
                        if (!$service->isDot()) {
                            $serviceName = $service->getFilename();
                            $serviceName = basename($serviceName, '.php');
                            $serviceName = "Sandy\Blocks\\$method\Services\\$serviceName";

                            // Register the service
                            if (!app()->getProviders($serviceName)) {
                                $this->app->register("$serviceName");
                            }
                        }
                    }
                }

                // Register views
                if (is_dir("$path/Views") ){
                    // Add view namespace
                    View::addNamespace('Blocks-' . $method, "{$path}/Views");
                }


                // Register Routes
                Route::middleware(['web', 'auth'])->prefix("mix/blocks/{$method}")->namespace("\Sandy\Blocks\\$method")->name("sandy-blocks-$method-")->group(function () use ($routes){
                    // Routes from app
                    if (file_exists($routes = $routes)) {
                        require $routes;
                    }
                });
            }
        }
    }

    public function payments(){
        if (!\SandyLicense::has_full_license()) {
            //my_log('Please register the application with a license before you use.');
           // return false;
        }

        $directory = new \DirectoryIterator(base_path('sandy/Payments'));
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $method = $info->getFilename();
                $path = $info->getPathname();

                // Route Path
                $GLOBALS['sandy_payment_routes'] = "{$path}/routes.php";

                // Register services

                if (is_dir($servicePath = base_path("sandy/Payments/$method/Services"))) {
                    $services = new \DirectoryIterator($servicePath);

                    // Loop services folder
                    foreach ($services as $service) {
                        if (!$service->isDot()) {
                            $serviceName = $service->getFilename();
                            $serviceName = basename($serviceName, '.php');
                            $serviceName = "Sandy\Payments\\$method\Services\\$serviceName";

                            // Register the service
                            if (!app()->getProviders($serviceName)) {
                                $this->app->register("$serviceName");
                            }
                        }
                    }
                }

                // Register views
                if (is_dir("$path/Views") ){
                    // Add view namespace
                    View::addNamespace('Payment-' . $method, "{$path}/Views");
                }


                // Register Routes
                Route::middleware('web')->prefix("payments/{$method}")->namespace("\Sandy\Payments\\$method")->name("sandy-payments-$method-")->group(function () {
                    // Routes from app
                    if (file_exists($routes = $GLOBALS['sandy_payment_routes'])) {
                        require $routes;
                    }
                });
            }
        }
    }

    public function bio(){
        if (!\SandyLicense::has_any_license()) {
            //my_log('Please register the application with a license before you use.');
            return false;
        }
        $directory = new \DirectoryIterator(base_path('sandy/Segment'));
        $i = 1;
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $segment = $info->getFilename();
                $path = $info->getPathname();

                $proceed = true;


                if ($proceed) {

                    // Route Path
                    $GLOBALS['sandy_app_routes'] = "{$path}/routes.php";

                    // Register services

                    if (is_dir($servicePath = base_path("sandy/Segment/$segment/Services"))) {
                        $services = new \DirectoryIterator($servicePath);

                        // Loop services folder
                        foreach ($services as $service) {
                            if (!$service->isDot()) {
                                $serviceName = $service->getFilename();
                                $serviceName = basename($serviceName, '.php');
                                $serviceName = "Sandy\Segment\\$segment\Services\\$serviceName";

                                // Register the service
                                if (!app()->getProviders($serviceName)) {
                                    $this->app->register("$serviceName");
                                }
                            }
                        }
                    }

                    // Register views
                    if (is_dir("$path/Views") ){
                        // Add view namespace
                        View::addNamespace('App-' . $segment, "{$path}/Views");
                    }


                    // Register Routes
                    Route::middleware('web')->prefix("elements/{$segment}")->namespace("\Sandy\Segment\\$segment")->name("sandy-app-$segment-")->group(function () {
                        // Routes from app
                        if (file_exists($routes = $GLOBALS['sandy_app_routes'])) {
                            require $routes;
                        }
                    });
                }
            }
        }
    }


    public function plugins(){
        if (!\SandyLicense::has_any_license()) {
            //my_log('Please register the application with a license before you use.');
            return false;
        }
        $directory = new \DirectoryIterator(base_path('sandy/Plugins'));
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $plugin = $info->getFilename();
                $path = $info->getPathname();

                $proceed = true;

                if (!\SandyLicense::has_plugin_license($plugin)) {
                    $proceed = true;
                }

                if ($proceed) {
                        
                    // Route Path
                    $GLOBALS['sandy_plugins_routes'] = "{$path}/routes.php";

                    if (is_dir($servicePath = base_path("sandy/Plugins/$plugin/Services"))) {
                        // Register services
                        $services = new \DirectoryIterator($servicePath);

                        // Loop services folder
                        foreach ($services as $service) {
                            if (!$service->isDot()) {
                                $serviceName = $service->getFilename();
                                $serviceName = basename($serviceName, '.php');
                                $serviceName = "Sandy\Plugins\\$plugin\Services\\$serviceName";

                                // Register the service
                                if (!app()->getProviders($serviceName)) {
                                    $this->app->register("$serviceName");
                                }
                            }
                        }
                    }

                    // Register views
                    if (is_dir("$path/Views") ){
                        // Add view namespace
                        View::addNamespace('Plugin-' . $plugin, "{$path}/Views");
                    }


                    // Register Routes
                    Route::middleware('web')->prefix("plugins/{$plugin}")->namespace("\Sandy\Plugins\\" . $plugin)->name("sandy-plugins-$plugin-")->group(function () {
                        // Routes from app
                        if (file_exists($routes = $GLOBALS['sandy_plugins_routes'])) {
                            require $routes;
                        }
                    });
                }
            }
        }
    }
}