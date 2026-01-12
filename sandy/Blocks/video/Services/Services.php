<?php

namespace Sandy\Blocks\video\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\video\Livewire\BlockWire;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('video-blocks-livewire', BlockWire::class);
    }

    public function register(){
    }
}