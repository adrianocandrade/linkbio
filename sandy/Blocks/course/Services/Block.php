<?php

namespace Sandy\Blocks\course\Services;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Route;

class Block extends ServiceProvider{

    public function boot(){
    }

    public function register(){
        $this->config();
    }



    public function config(){

        $config = [
            'course' => [
                'name' => 'Course',
                'desc' => 'Add courses & lessons to your page',
                'route' => 'sandy-blocks-course-mix-dashboard',
                'orion' => 'cinema-projector-1',
            ],
        ];

        \Blocks::add_config($config);
    }
}