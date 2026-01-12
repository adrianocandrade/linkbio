<?php

namespace Modules\Admin\Http\Controllers\Plugins;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins;
use App\Payments;

class ElementsController extends Controller{
    public $dir = 'sandy/Segment';
    public function elements(){
        // Get All Elements
        $elements = getAllBioApps();

        // Return view
        return view('admin::plugins.elements.elements', ['elements' => $elements]);
    }

    public function make_all_public(){
        $elements = getAllBioApps();

        foreach ($elements as $key => $value) {
            \Elements::makePublic($key);
        }


        return redirect()->route('admin-bio-elements')->with('success', __('Elements assets moved to public'));
    }


    public function configure($element){
        // Config
        if (!$config = \Elements::config($element)) {
            abort(404);
        }

        $con = function($key = null) use ($element){
            return ao(\Elements::config($element), $key);
        };

        return view('admin::plugins.elements.configure', ['element' => $element, 'config' => $config, 'con' => $con]);
    }

    public function configure_post($element, Request $request){
        // Config
        if (!$config = \Elements::config($element)) {
            abort(404);
        }

        if (!empty($request->config)) {
            foreach ($request->config as $key => $value) {
                $config[$key] = $value;
            }
        }

        if (!empty($request->config_value)) {
            foreach ($request->config_value as $key => $value) {
                $config['config'][$key]['value'] = $value;
            }
        }


        $update = $config;

        \Elements::putConfig($element, $update);



        return back()->with('success', __('Config updated'));
    }

    public function elementsPost(Request $request){
        $payments = new Payments;

        // Validate the request
        $request->validate([
            'archive' => 'required|file|mimes:zip',
        ]);

        // Folder location
        $location = $this->dir;

        $archiveName = $request->file('archive')->getClientOriginalName();

        // Move to folder
        
        $request->archive->move(base_path($location), $archiveName);

        $pathinfo = pathinfo($archiveName);

        // Unzip the file
        try {
            $zipper = new \Madnest\Madzipper\Madzipper;
            $zipper->make(base_path("$location/$archiveName"))->extractTo(base_path($location));
            $zipper->close();
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        // Unlink the file
        unlink(base_path("$location/$archiveName"));
        \Elements::makePublic(ao($pathinfo, 'filename'));

        // Return back
        return back()->with('success', __("Element uploaded successfully."));
    }

    public function delete(Request $request){
        //

        \Elements::removePublic($request->plugin);

        if (file_exists($path = base_path("$this->dir/$request->plugin"))) {

            try {
                \File::deleteDirectory($path);
            } catch (\Exception $e) {
                return back()->with('error', $e->getMessage());
            }
            // Return back
            return back()->with('success', __("Element deleted."));
        }
        
        // Return back
        
        return back()->with('error', __("Could not find element."));
    }
}
