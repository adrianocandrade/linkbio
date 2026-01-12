<?php

namespace Sandy\Blocks\shop\Services;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Route;

class Block extends ServiceProvider{

    protected $block_name = 'shop';

    public function boot(){
    }

    public function register(){
        $this->config();
    }



    public function config(){

        $config = [
            'shop' => [
                'name' => 'Shop',
                'desc' => 'Let your visitors shop from your page',
                'route' => 'sandy-blocks-shop-mix-view',
                'orion' => 'store-1',
            ],
        ];

        \Blocks::add_config($config);
    }
}