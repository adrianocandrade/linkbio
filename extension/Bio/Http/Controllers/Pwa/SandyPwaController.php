<?php

namespace Modules\Bio\Http\Controllers\Pwa;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;
use Modules\Bio\Http\Controllers\Base\Controller;

class SandyPwaController extends Controller{

    public function manifest(){
        user_manifest($this->bio->id);
        $output = (new \App\Pwa\Service\ManifestService)->init();
        return response()->json($output);
    }
}