<?php

namespace Sandy\Segment\image_album\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function edit($slug){
        return view("App-$this->name::edit");
    }

    public function editPost(Request $request){
        $request->validate([
            'label' => 'required'
        ]);

        $content = $this->element->content;

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        $extra = [
            'name' => $request->label
        ];

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }

    public function sortImages(Request $request){
        $content = $this->element->content;
        $images = [];
        if (!is_array(ao($content, 'images'))) {
            return false;
        }
        foreach($request->data as $key) {
           $images[] = $key['id'];
        }


        $content['images'] = $images;
        $update = updateElement($this->element->id, $content);
    }

    public function addImages(Request $request){
        $size = (int) \Elements::config('image_album', 'config.file_size.value');
        $size = "{$size}000";
        $formats = \Elements::config('image_album', 'config.file_size.formats');
        $max_file = (int) \Elements::config('image_album', 'config.max_files.value');
        $content = $this->element->content;

        if (is_array(ao($content, 'images')) && count(ao($content, 'images')) >= $max_file) {
            return back()->with('error', __('Exceeded the maximum allowed images(s) of "'. $max_file .'".'));
        }


        // Validate image
        $request->validate([
            'image_album' => 'required|mimes:'. $formats .'|max:'. $size,
        ]);

        $pathinfo = pathinfo($request->file('image_album')->getClientOriginalName());
        $name = 'gallery_' . strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

        $file = \UserStorage::putAs('media/element/others', $request->image_album, $name, $this->bio->id);


        $content['images'][] = $file;
        $update = updateElement($this->element->id, $content);


        return back()->with('success', __('Image added.'));
    }


    public function deleteImages($slug, Request $request){
        if (!is_array($images = ao($this->element->content, 'images'))) {
            return back()->with('error', __('Could not find file'));
        }


        if (mediaExists('media/element/others', $request->image)) {
            \UserStorage::remove('media/element/others', $request->image);

            $content = $this->element->content;

            foreach ($images as $key => $value) {
                if ($request->image == $value) {
                    unset($content['images'][$key]);
                }
            }

            $update = updateElement($this->element->id, $content);

            return back()->with('success', __('File removed successfully'));
        }
        
        return back()->with('error', __('Could not find file'));
    }
}