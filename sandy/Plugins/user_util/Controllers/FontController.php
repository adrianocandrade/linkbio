<?php

namespace Sandy\Plugins\user_util\Controllers;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;

class FontController extends Controller{
    public $plugin = 'user_util';
    public function fonts(){
        $allFonts = $this->allFonts();

        return view('Plugin-user_util::fonts.all', ['allFonts' => $allFonts]);
    }

    public function Newfonts(){
        $allFonts = $this->allFonts();;

        return view('Plugin-user_util::fonts.add', ['allFonts' => $allFonts]);
    }

    public function deleteFont(Request $request){
        // Get Our Fonts Path
        $font_path = $this->font_path();

        // All Current User Fonts
        $fonts = fonts();

        if (array_key_exists($font = $request->font, $fonts)) {
            unset($fonts[$font]);
        }

        // Pretty Json
        $data = Collection::make($fonts)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($font_path, $data);

        // Return Back with success
        return back()->with('success', __('Font Removed Successfully.'));
    }

    public function sortFont(Request $request){
        // Get Our Fonts Path
        $font_path = $this->font_path();

        // All Current User Fonts
        $fonts = fonts();
        // New Order List
        $new = [];

        foreach ($request->data as $key => $value) {
            $value = $value['id'];
            if (array_key_exists($value, $fonts)) {
                $new[$value] = $fonts[$value];
            }
        }



        // Pretty Json
        $data = Collection::make($new)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($font_path, $data);

        // Return true since it's XHR
        return true;
    }


    public function addFont(Request $request){
        // Get Our Fonts Path
        $font_path = $this->font_path();

        // All Current User Fonts
        $fonts = fonts();

        // Get All Fonts
        $allFonts = $this->allFonts();

        // Check if is array
        if (!empty($font = $request->font)) {

            // Loop our requested fonts
            foreach ($font as $key => $value) {
                // Check if fonts exists in all fonts
                if (array_key_exists($value, $allFonts)) {

                    // Add our fonts to user fonts
                    $fonts[$value] = $allFonts[$value];
                }
            }
        }

        // Pretty Json
        $data = Collection::make($fonts)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($font_path, $data);

        // Return Back with success
        return back()->with('success', __('Font Added Successfully.'));
    }

    private function font_path(){
        // Get Our Fonts Path
        return base_path('resources/others/fonts.php');
    }

    public function allFonts(){
        $path = base_path("sandy/Plugins/$this->plugin/Others/1000-fonts.php");
        $file = file_get_contents($path);

        $allFonts = [];

        if (file_exists($path)) {
            $allFonts = json_decode($file, true);
        }

        return $allFonts;
    }
}