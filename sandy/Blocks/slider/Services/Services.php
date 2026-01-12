<?php

namespace Sandy\Blocks\slider\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\slider\Livewire\BlockWire;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('slider-blocks-livewire', BlockWire::class);
    }

    public function register(){
    }
}