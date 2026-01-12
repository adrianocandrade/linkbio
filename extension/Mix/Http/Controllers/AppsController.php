<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\BioApp;

class AppsController extends Controller{
    public function add(Request $request){
        $apps = getAllBioApps();

        if (!empty($query = $request->get('query'))) {
            $apps = [];
            foreach (getAllBioApps() as $key => $value) {
                $name = \Str::lower(ao($value, 'name'));
                $query = \Str::lower($query);

                if (\Str::contains($name, $query)) {
                    $apps[$key] = $value;
                }
            }
        }
        
        return view('mix::app.all', ['apps' => $apps]);
    }
}
