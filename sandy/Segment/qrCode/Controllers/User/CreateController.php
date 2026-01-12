<?php

namespace Sandy\Segment\qrCode\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'qrCode';
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
            'url' => 'required',
            'caption' => 'required'
        ]);

        $content = [
            'caption' => $request->caption,
            'url'     => $request->url
        ];

        $extra = [
            'name' => $request->label
        ];

        // Thumbnail

        $process_image = $this->processImage($request, 'sandy_upload_media_upload');
        // Thumbnail
        $thumbnail = [
            'type' => $request->sandy_upload_media_type,
            'upload' => $process_image,
            'link' => $request->sandy_upload_media_link
        ];
        $extra['thumbnail'] = $thumbnail;

        $insert = insertElement($this->user->id, $this->element, $content, $extra);


        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }



    private function processImage($request, $input){
        $image_size = (int) \Elements::config('qrCode', 'config.cover_size.value');
        $image_size = "{$image_size}000";

        if (empty($request->{$input})) {
            return false;
        }

        // Validate image
        $request->validate([
            $input => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,avi|max:'. $image_size,
        ]);

        // Image name
        $image = \UserStorage::put('media/element/thumbnail', $request->{$input}, $this->user->id);

        // Return image name
        return $image;
    }
}