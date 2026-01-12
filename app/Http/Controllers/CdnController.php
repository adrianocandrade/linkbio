<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;

class CdnController extends Controller{
    public function cdn(Request $request){
        $photo = '';
        // Check for photo in query
        if (!empty($photo = $request->get('photo'))) {
            // Change Width
            $photo = $photo;
        }

        $can_resize = false;

        // No Width
        $width = null;

        // Check for width in query
        if (!empty($width = $request->get('width'))) {
            // Change Width
            $width = $width;
            $can_resize = true;
        }


        // No Height
        $height = null;
        // Check for height in query
        if (!empty($height = $request->get('height'))) {
            // Change height
            $height = $height;
            $can_resize = true;
        }


        $image = new \Intervention\Image\ImageManager();
        // Path 
        if (strpos($photo, '..') !== false) {
             return __('Invalid Path');
        }
        $path = public_path("$photo");
        
        $realPath = realpath($path);
        
        if (!$realPath || !str_starts_with($realPath, public_path())) {
             return __('Media Doesnt Exists (Security)');
        }

        if (!file_exists($path)) {
            return __('Media Doesnt Exists');
        }

        $res = $image->cache(function ($image) use ($path, $width, $height, $can_resize) {
            $return = $image->make($path);
            if ($can_resize) {
                $return = $return->resize($width, $height);
            }


            return $return;
        }, 9999, true);

        return $res->response();


        abort(404);
    }
}
