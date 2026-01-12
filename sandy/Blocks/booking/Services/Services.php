<?php

namespace Sandy\Blocks\booking\Services;
use Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

class Services extends ServiceProvider{

    protected $block_name = 'booking';

    public function boot(){
        $array = [
            'block_booking' => [
                'name' => 'Booking',
                'description' => 'Users have access to booking block',
            ]
        ];



        $get_skeleton = getOtherResourceFile('plan');

        $skeleton = $get_skeleton;

        foreach ($array as $key => $value) {
            $skeleton[$key] = $value;
        }

        if (!array_key_exists('block_booking', $get_skeleton)) {
            $skeleton = "<?php\n\n return " . (new \Riimu\Kit\PHPEncoder\PHPEncoder())->encode($skeleton) . "; \n";
            file_put_contents(base_path('resources') . "/others/plan.php", $skeleton);
        }

        if (!Schema::hasTable('booking_appointments')) {
            try {
                Artisan::call('migrate', ["--force" => true, '--path' => "/sandy/Blocks/$this->block_name/Migrations"]);
            } catch (\Exception $e) {
                
            }
        }

        Livewire::component('booking-block-mix-services-livewire', \Sandy\Blocks\booking\Livewire\Services::class);
        
        Livewire::component('booking-block-mix-breaks-livewire', \Sandy\Blocks\booking\Livewire\Breaks::class);

        Livewire::component('booking-block-mix-calendar-livewire', \Sandy\Blocks\booking\Livewire\Calendar::class);

        Livewire::component('booking-block-mix-portfolio-livewire', \Sandy\Blocks\booking\Livewire\Portfolio::class);

        Livewire::component('booking-block-bio-booking', \Sandy\Blocks\booking\Livewire\Booking::class);
        
        //$this->loadMigrationsFrom(block_path($this->block_name, 'Migrations'));
    }

    public function register(){
        
    }
}