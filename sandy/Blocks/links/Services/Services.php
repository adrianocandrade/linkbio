<?php

namespace Sandy\Blocks\links\Services;
use Route;
use Livewire\Livewire;
use Sandy\Blocks\links\Livewire\Links;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{
    public function boot(){
        Livewire::component('links-blocks-livewire', Links::class);
    }

    public function register(){
    }
}