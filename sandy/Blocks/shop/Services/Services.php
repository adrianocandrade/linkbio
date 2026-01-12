<?php

namespace Sandy\Blocks\shop\Services;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Route;

class Services extends ServiceProvider{

    protected $block_name = 'shop';

    public function boot(){
        $array = [
            'block_shop' => [
                'name' => 'Shop',
                'description' => 'Users have access to shop block',
            ]
        ];



        $get_skeleton = getOtherResourceFile('plan');

        $skeleton = $get_skeleton;

        foreach ($array as $key => $value) {
            $skeleton[$key] = $value;
        }

        if (!array_key_exists('block_shop', $get_skeleton)) {
            $skeleton = "<?php\n\n return " . (new \Riimu\Kit\PHPEncoder\PHPEncoder())->encode($skeleton) . "; \n";
            file_put_contents(base_path('resources') . "/others/plan.php", $skeleton);
        }

        if (!Schema::hasTable('products')) {
            try {
                Artisan::call('migrate', ["--force" => true, '--path' => "/sandy/Blocks/$this->block_name/Migrations"]);
            } catch (\Exception $e) {
                
            }
        }

        //$this->loadMigrationsFrom(block_path($this->block_name, 'Migrations'));
    }

    public function register(){
        $this->app->register('Darryldecode\Cart\CartServiceProvider');
        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('DarryCart', 'Darryldecode\Cart\Facades\CartFacade');


        $this->config();
    }



    public function config(){
        $config = [
            'format_numbers' => env('SHOPPING_FORMAT_VALUES', false),

            'decimals' => env('SHOPPING_DECIMALS', 0),

            'dec_point' => env('SHOPPING_DEC_POINT', '.'),

            'thousands_sep' => env('SHOPPING_THOUSANDS_SEP', ','),

            /*
             * ---------------------------------------------------------------
             * persistence
             * ---------------------------------------------------------------
             *
             * the configuration for persisting cart
             */
            'storage' => null,

            /*
             * ---------------------------------------------------------------
             * events
             * ---------------------------------------------------------------
             *
             * the configuration for cart events
             */
            'events' => null,
        ];


        config(['shopping_cart' => $config]);
    }
}