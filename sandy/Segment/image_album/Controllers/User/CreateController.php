<?php

namespace Sandy\Segment\image_album\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'image_album';
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
            'image_album' => 'required'
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        $extra = [
           'name' => $request->label
        ];

        $content['images'][] = $this->images($request);
        $insert = insertElement($this->user->id, $this->element, $content, $extra);

        $slug = $insert['model']->slug;

        // Return to elements
        return redirect()->route('sandy-app-image_album-edit', $slug)->with('success', __('Saved Successfully'));
    }

    private function images($request){
        $size = (int) \Elements::config('image_album', 'config.file_size.value');
        $size = "{$size}000";
        $formats = \Elements::config('image_album', 'config.file_size.formats');

        if (empty($request->image_album)) {
            return false;
        }

        // Validate image
        $request->validate([
            'image_album' => 'required|mimes:'. $formats .'|max:'. $size,
        ]);

        $pathinfo = pathinfo($request->file('image_album')->getClientOriginalName());

        $name = 'gallery_' . strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');
        $file = \UserStorage::putAs('media/element/others', $request->image_album, $name, $this->user->id);

        // Return image name
        return $file;
    }
}