<?php

namespace Sandy\Blocks\lists\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\lists\Livewire\BlockWire;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('lists-blocks-livewire', BlockWire::class);
    }

    public function register(){
    }
}