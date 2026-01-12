<?php

namespace Modules\Index\Http\Controllers;

use App\Elements;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(){
        // Check for custom index
        if (!empty($redirect = settings('others.redirect_url'))) {
            return redirect($redirect);
        }

        return view('index::index');
    }

    public function switchLocale(Request $request){
        if (!empty($request->locale)) {
            \Cookie::queue('sandy_locale', $request->locale, time() + 60 * 60 * 24 * 365);
        }


        return back()->with('success', __('Language changed.'));
    }

    

    public function apps(Request $request){

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
        

        return view('index::elements.index', ['apps' => $apps]);
    }


    public function apps_view(Request $request){
        $element = $request->element;
        if (!Elements::has($element)) {
            abort(404);
        }

        $config = function($key = null) use ($element){
            return Elements::config($element, $key);
        };


        return view('index::elements.preview', ['element' => $element, 'config' => $config]);
    }
}
