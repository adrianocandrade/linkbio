<?php

namespace Sandy\Segment\annoymous_message\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'annoymous_message';
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function create(){
        return view("App-$this->element::create");
    }

    public function createPost(Request $request){
        $elm_check = (new \Elements)->is_in_plan($this->element);
        if (!ao($elm_check, 'status')) {
            return back()->with('error', ao($elm_check, 'message'));
        }
        
        $request->validate([
            'label' => 'required',
            'caption' => 'required'
        ]);

        $content = [
            'caption' => $request->caption
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
            
            $name = putStorage('media/element/thumbnail', $request->cover);

            $thumbnail = ['type' => 'upload', 'thumbnail' => $name];

            $extra['thumbnail'] = $thumbnail;
        }

        $insert = insertElement($this->user->id, $this->element, $content, $extra);

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }
}