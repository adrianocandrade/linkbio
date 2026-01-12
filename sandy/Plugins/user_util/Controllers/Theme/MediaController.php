<?php

namespace Sandy\Plugins\user_util\Controllers\Theme;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Route;

class MediaController extends Controller{
    public function makePublic($theme){
        if (!\BioStyle::has($theme)) {
            abort(404);
        }

        \BioStyle::makePublic($theme);

        //
        return redirect()->route('sandy-plugins-user_util-themes-edit', $theme)->with('success', __('Media made public.'));
    }

    public function uploadMedia($theme, Request $request){
        if (!\BioStyle::has($theme)) {
            abort(404);
        }
        $path = \BioStyle::path();
        $location = "$path/$theme/media";

        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mediaName = \Str::random(4) .'.'. $request->media->extension();

        $request->media->move($location, $mediaName);

        \BioStyle::makePublic($theme);

        //
        return redirect()->route('sandy-plugins-user_util-themes-edit', $theme)->with('success', __('Media uploaded successfully.'));
    }


    public function deleteMedia($theme, $media, Request $request){
        $path = \BioStyle::path();
        $location = "$path/$theme/media";
        //
        if (!$config = \BioStyle::config($theme)) {
            abort(404);
        }

        $extensions = ['jpeg','png','jpg','gif','svg'];

        foreach (\BioStyle::getMediaNames($theme) as $key => $value) {
            if ($media == pathinfo($value, PATHINFO_FILENAME)) {
                if (file_exists($unlink = "$location/$value")) {
                    unlink($unlink);
                }
            }
        }

        \BioStyle::makePublic($theme);

        return redirect()->route('sandy-plugins-user_util-themes-edit', $theme)->with('success', __('Media removed successfully.'));
    }
}