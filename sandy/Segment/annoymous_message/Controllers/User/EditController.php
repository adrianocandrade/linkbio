<?php

namespace Sandy\Segment\annoymous_message\Controllers\User;

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
            'label' => 'required',
            'caption' => 'required'
        ]);

        $content = [
            'caption' => $request->caption,
        ];
        
        $extra = [
            'name' => $request->label
        ];
        
        $cover_size = \Elements::config('annoymous_message', 'config.cover_size.value');
        $cover_size = "{$cover_size}000";

        if (!empty($request->cover)) {
            $request->validate([
                'cover' => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,avi|max:'. $cover_size,
            ]);

            if (mediaExists('media/element/thumbnail', ao($this->element->thumbnail, 'thumbnail'))) {
                storageDelete('media/element/thumbnail', ao($this->element->thumbnail, 'thumbnail'));
            }
            
            $name = putStorage('media/element/thumbnail', $request->cover);

            $thumbnail = ['type' => 'upload', 'thumbnail' => $name];

            $extra['thumbnail'] = $thumbnail;
        }

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}