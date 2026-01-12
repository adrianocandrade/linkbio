<?php

namespace Sandy\Plugins\user_util\Controllers\Theme;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;

class EditController extends Controller{
    public function theme($theme){

        if (!\BioStyle::has($theme)) {
            abort(404);
        }

        $config = function($key = null) use ($theme){
            $config = \BioStyle::config($theme);
            return ao($config, $key);
        };

        return view('Plugin-user_util::theme.edit', ['theme' => $theme, 'config' => $config]);
    }


    public function editPost($theme, Request $request){
        $path = \BioStyle::getdir($theme, 'config.php');

        //
        if (!$config = \BioStyle::config($theme)) {
            abort(404);
        }

        if (!empty($conf = $request->config)) {
            foreach ($conf as $key => $value) {
                $config[$key] = $value;
            }
        }

        if (!empty($defaults = $request->defaults)) {
            foreach ($defaults as $key => $value) {
                $config['defaults'][$key] = $value;
            }
        }

        if (!empty($background = $request->background)) {
            foreach ($background as $key => $value) {
                $config['defaults']['background'][$key] = $value;
            }
        }

        if (!empty($color = $request->color)) {
            foreach ($color as $key => $value) {
                $config['defaults']['color'][$key] = $value;
            }
        }

        // Pretty Json
        $data = Collection::make($config)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        // Put Content
        file_put_contents($path, $data);

        return back()->with('success', __('Saved Successfully.'));
    }
}