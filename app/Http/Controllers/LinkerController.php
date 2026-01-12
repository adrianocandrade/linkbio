<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;

class LinkerController extends Controller{
    public function redirect($slug){
        // Get linker
        $linker = Linker::slug($slug)->first();

        // Check if linker exists
        if (!$linker) {
            abort(404);
        }
        
        // Track links in our model
        $track = Linkertrack::track($linker->id, $linker->slug, $linker->url, $linker->user);


        // Redirect to url
        return redirect($linker->url);
    }
}
