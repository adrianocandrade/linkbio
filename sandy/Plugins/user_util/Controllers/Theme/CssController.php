<?php

namespace Sandy\Plugins\user_util\Controllers\Theme;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Route;

class CssController extends Controller{
    public function edit($theme, $css){

        if (!\BioStyle::has($theme)) {
            abort(404);
        }

        if (!file_exists($cssPath = \BioStyle::getdir($theme, "css/$css.css"))) {
            abort(404);
        }

        $config = function($key = null) use ($theme){
            $config = \BioStyle::config($theme);
            return ao($config, $key);
        };

        $cssFile = file_get_contents($cssPath);

        return view('Plugin-user_util::theme.css', ['theme' => $theme, 'config' => $config, 'css' => $css, 'cssFile' => $cssFile]);
    }

    public function uploadCss($theme, Request $request){
        if (!\BioStyle::has($theme)) {
            abort(404);
        }
        $location = \BioStyle::getdir($theme, "css");

        $request->validate([
            'css' => 'required|file|max:2048',
        ]);

        $extensions = ['css'];

        $pathinfo = pathinfo($request->file('css')->getClientOriginalName());

        if (!in_array(ao($pathinfo, 'extension'), $extensions)) {
            return back()->with('error', __('validation.mimes', ['attribute' => 'css file', 'values' => 'css']));
        }

        $cssName = ao($pathinfo, 'filename') .'_'. strtolower(\Str::random(3)) . '.css';

        if (!is_dir($location)) {
            
            if (!mkdir($location, 0770, true)) {
                return back()->with('error', __('Css folder could not be created.'));
            }
        }

        $request->css->move($location, $cssName);

        //
        return back()->with('success', __('Media uploaded successfully.'));
    }


    public function editPost($theme, $css, Request $request){
        if (!file_exists($cssPath = \BioStyle::getdir($theme, "css/$css.css"))) {
            abort(404);
        }

        // Put Content
        file_put_contents($cssPath, $request->css);

        return back()->with('success', __('Saved Successfully.'));
    }


    public function delete($theme, $css, Request $request){
        if (!file_exists($cssPath = \BioStyle::getdir($theme, "css/$css.css"))) {
            abort(404);
        }

        // Put Content
        unlink($cssPath);

        return redirect()->route('sandy-plugins-user_util-themes-edit', $theme)->with('success', __('Deleted Successfully.'));
    }
}