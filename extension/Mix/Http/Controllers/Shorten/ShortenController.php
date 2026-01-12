<?php

namespace Modules\Mix\Http\Controllers\Shorten;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\BioApp;

class ShortenController extends Controller{
    public function index(Request $request){



        return view('mix::shorten.shorten');
    }


    public function shorten(Request $request){
        $request->validate([
            'link' => 'required'
        ]);

        $scheme = $this->addscheme($request->link);
        $linker = linker($scheme, $this->user->id);


        return view('mix::shorten.shorten-valid', ['linker' => $linker]);
    }


    public function addscheme($url){
        $url = addHttps($url);

        if (validate_url($url)) {
            return $url;
        }


        return false;
    }
}
