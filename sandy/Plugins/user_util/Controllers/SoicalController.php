<?php

namespace Sandy\Plugins\user_util\Controllers;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;

class SoicalController extends Controller{
    public function socials(){
        return view('Plugin-user_util::social.all');
    }

    public function postNewSocial(Request $request){
        // Social Path
        $path = $this->social_path();

        // Validate request
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'icon'  => 'required'
        ]);

        // Socials
        $socials = socials();
        // Make the Slug a name
        $name = slugify($request->name);
        //
        $social = [
            'name' => $request->name,
            'address' => $request->address,
            'color' => $request->color,
            'icon' => $request->icon
        ];

        $socials[$name] = $social;

        // Pretty Json
        $data = Collection::make($socials)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($path, $data);

        // Return Back with success
        return back()->with('success', __('Social Added Successfully.'));
    }

    public function editPost($social, Request $request){
        // Validate request
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'icon'  => 'required'
        ]);
        // Social Path
        $path = $this->social_path();

        // Socials
        $socials = socials();

        // If Social Exists
        if (!array_key_exists($social, $socials)) {
            abort(404);
        }

        // Social Array
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'color' => $request->color,
            'icon' => $request->icon
        ];

        $socials[$social] = $data;
        // Pretty Json
        $data = Collection::make($socials)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($path, $data);
        
        // Return Back with success
        return back()->with('success', __('Social Saved Successfully.'));
    }

    public function delete($social){
        // Social Path
        $path = $this->social_path();

        // Socials
        $socials = socials();

        // If Social Exists
        if (!array_key_exists($social, $socials)) {
            abort(404);
        }

        unset($socials[$social]);
        // Pretty Json
        $data = Collection::make($socials)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($path, $data);
        
        // Return Back with success
        return back()->with('success', __('Removed Successfully.'));
    }

    public function edit($social){
        // Social Path
        $path = $this->social_path();

        // Socials
        $socials = socials();

        if (!array_key_exists($social, $socials)) {
            abort(404);
        }

        $data = ao($socials, $social);

        return view('Plugin-user_util::social.edit', ['social' => $social, 'data' => $data]);
    }

    private function social_path(){
        // Get Our Fonts Path
        return base_path('resources/others/socials.php');
    }
}