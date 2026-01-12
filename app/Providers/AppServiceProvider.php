<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(){
        \Schema::defaultStringLength(191);
        
        if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {

        }else{
           \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Carbon\Carbon::setLocale('pt_BR');

        
        // Registrar componente Livewire de Booking
        // O componente está em Sandy\Blocks\booking\Livewire mas precisa ser registrado manualmente
        // porque o namespace padrão do Livewire é App\Http\Livewire
        \Livewire\Livewire::component('booking-block-bio-booking', 
            \Sandy\Blocks\booking\Livewire\Booking::class);
    }
}
