<?php

namespace Modules\Admin\Http\Controllers\Plugins\Elements;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins;
use App\Payments;

class ConfigureController extends Controller{
    public $dir = 'sandy/Segment';


    public function makePublic($element){
        
    }

    public function uploadGallery($element){
        
    }

    public function assetsGallery($element){
        // Config
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
        
        
    }
}
