<?php

namespace Modules\Admin\Http\Controllers\Plugins\Elements;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class MediaController extends Controller{
    public $dir = 'sandy/Segment';


    public function makePublic($element){
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
        
        $gallery = [];

        foreach (\Elements::getGalleryNames($element) as $key => $value) {
            $gallery[] = $value;
        }

        $config['gallery'] = $gallery;

        \Elements::putConfig($element, $config);

        \Elements::makePublic($element);

        return redirect()->route('admin-bio-elements-configure', $element)->with('success', __('Element folder made public'));
    }

    public function sortGallery($element, Request $request){
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
         $images = [];
         foreach($request->data as $key) {
            $images[] = $key['id'];
         }

        $config['gallery'] = $images;

        \Elements::putConfig($element, $config);

        return true;
    }

    public function uploadGallery($element, Request $request){
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
        $location = \Elements::getdir($element, 'Media/gallery');

        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $pathinfo = pathinfo($request->file('media')->getClientOriginalName());
        $mediaName = ao($pathinfo, 'filename') .'_'. strtolower(\Str::random(2)) .'.'. ao($pathinfo, 'extension');

        $request->media->move($location, $mediaName);
        
        $gallery = [];

        foreach (\Elements::getGalleryNames($element) as $key => $value) {
            $gallery[] = $value;
        }

        $config['gallery'] = $gallery;

        \Elements::putConfig($element, $config);

        \Elements::makePublic($element);

        return back()->with('success', __('Gallery added successfully'));
        
    }

    public function deleteGallery($element, $media){
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
        $location = \Elements::getdir($element, 'Media/gallery');

        $extensions = ['jpeg','png','jpg','gif','svg'];

        foreach (\Elements::getGalleryNames($element) as $key => $value) {
            if ($media == pathinfo($value, PATHINFO_FILENAME)) {
                if (file_exists($unlink = "$location/$value")) {
                    unlink($unlink);
                }
            }
        }

        $gallery = [];

        foreach (\Elements::getGalleryNames($element) as $key => $value) {
            $gallery[] = $value;
        }

        $config['gallery'] = $gallery;

        \Elements::putConfig($element, $config);

        \Elements::makePublic($element);
        
        return back()->with('success', __('Gallery image removed'));
    }

    public function deleteAssets($element, $media){
        if (!$config = \Elements::config($element)) {
            abort(404);
        }
        $location = \Elements::getdir($element, 'Media/assets');

        $extensions = ['css','js'];

        foreach (\Elements::getAssetsNames($element) as $key => $value) {
            if ($media == pathinfo($value, PATHINFO_FILENAME)) {
                if (file_exists($unlink = "$location/$value")) {
                    unlink($unlink);
                }
            }
        }

        \Elements::makePublic($element);
        
        return back()->with('success', __('Asset removed'));
    }

    public function uploadAssets($element, Request $request){
        // Config
        if (!$config = \Elements::config($element)) {
            abort(404);
        }

        $request->validate([
            'file' => 'required|file|max:2048',
        ]);
        
        $location = \Elements::getdir($element, 'Media/assets');
        $extensions = ['css', 'js'];

        $pathinfo = pathinfo($request->file('file')->getClientOriginalName());
        
        if (!in_array(ao($pathinfo, 'extension'), $extensions)) {
            return back()->with('error', __('validation.mimes', ['attribute' => 'file', 'values' => 'css / js']));
        }

        $fileName = ao($pathinfo, 'filename') .'_'. strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

        if (!is_dir($location)) {
            
            if (!mkdir($location, 0770, true)) {
                return back()->with('error', __('Asset folder could not be created.'));
            }
        }


        $request->file->move($location, $fileName);

        \Elements::makePublic($element);

        //
        return back()->with('success', __('Asset uploaded successfully.'));
    }
}
