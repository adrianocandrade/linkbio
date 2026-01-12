<?php

namespace Sandy\Blocks\booking\Services;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Route;

class Block extends ServiceProvider{

    protected $block_name = 'booking';

    public function boot(){
    }

    public function register(){
        $this->config();
    }



    public function config(){

        $config = [
            'booking' => [
                'name' => 'Booking',
                'desc' => 'Let your visitors book from your page',
                'route' => 'sandy-blocks-shop-booking-view',
                'orion' => 'store-1',
            ],
        ];

        \Blocks::add_config($config);
    }
}