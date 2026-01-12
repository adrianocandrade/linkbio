<?php

namespace Sandy\Blocks\image\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\image\Livewire\BlockWire;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('image-blocks-livewire', BlockWire::class);
    }

    public function register(){
    }
}