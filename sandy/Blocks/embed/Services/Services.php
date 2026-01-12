<?php

namespace Sandy\Blocks\embed\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\embed\Livewire\BlockWire;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('embed-blocks-livewire', BlockWire::class);
    }

    public function register(){
    }
}