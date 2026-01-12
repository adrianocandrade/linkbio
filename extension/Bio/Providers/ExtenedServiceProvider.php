<?php

namespace Modules\Bio\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\User;
use Illuminate\Http\Request;
use App\Models\Domain as Userdomain;

class ExtenedServiceProvider extends ServiceProvider{
    protected $namespace = 'Modules\Bio\Http\Controllers';
    protected $routeName = 'user-bio-';
    public $prefix = '@{bio}';
    public $domainOrPrefix = 'prefix';
    public $user;

    public function __construct(){
        $this->prefix = config('app.bio_prefix') . '{bio}';
    }


    public function boot(){

        if (app()->runningInConsole()) {
            return;
        }
        // Check if system is subdomain or subdirectory
        if (config('app.BIO_WILDCARD')) {
            $this->prefix = '{bio}.' . parse(config('app.BIO_WILDCARD_DOMAIN'), 'host');
            $this->domainOrPrefix = 'domain';
        }

        $domain = request()->getHost();
        $domainModel = Userdomain::where('host', $domain)->first();

        if ($domainModel) {
            if (plan('settings.custom_domain', $domainModel->user)) {
                $this->domainOrPrefix = 'domain';
                $this->prefix = $domainModel->host;
            }
        }

        // Register Route
        Route::middleware(['web', 'bio'])->name($this->routeName)->namespace($this->namespace)->group(function(){
            // Group Route with prefix
            Route::group([$this->domainOrPrefix => $this->prefix], function(){
                require module_path('Bio', '/Routes/web.php');


                $this->bio_block_route();
            });
        });
    }


    public function register(){
        
    }






    public function bio_block_route(){

        $directory = new \DirectoryIterator(base_path('sandy/Blocks'));
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $method = $info->getFilename();
                $path = $info->getPathname();

                // Route Path
                $routes = "{$path}/bio-routes.php";


                // Register Routes
                Route::middleware(['web'])->prefix("{$method}")->namespace("\Sandy\Blocks\\$method")->name("sandy-blocks-$method-")->group(function () use ($routes){
                    // Routes from app
                    if (file_exists($routes = $routes)) {
                        require $routes;
                    }
                });
            }
        }
    }
}