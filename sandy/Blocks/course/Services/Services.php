<?php

namespace Sandy\Blocks\course\Services;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Route;

class Services extends ServiceProvider{

    protected $block_name = 'course';

    public function boot(){
        $array = [
            'block_course' => [
                'name' => 'Course',
                'description' => 'Users have access to course block',
            ]
        ];



        $get_skeleton = getOtherResourceFile('plan');

        $skeleton = $get_skeleton;

        foreach ($array as $key => $value) {
            $skeleton[$key] = $value;
        }

        if (!array_key_exists('block_course', $get_skeleton)) {
            $skeleton = "<?php\n\n return " . (new \Riimu\Kit\PHPEncoder\PHPEncoder())->encode($skeleton) . "; \n";
            file_put_contents(base_path('resources') . "/others/plan.php", $skeleton);
        }

        if (!Schema::hasTable('courses')) {
            try {
                Artisan::call('migrate', ["--force" => true, '--path' => "/sandy/Blocks/$this->block_name/Migrations"]);
            } catch (\Exception $e) {
                
            }
        }

        //$this->loadMigrationsFrom(block_path($this->block_name, 'Migrations'));
    }

    public function register(){
        
    }
}