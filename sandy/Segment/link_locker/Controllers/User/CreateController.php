<?php

namespace Sandy\Segment\link_locker\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'link_locker';
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
            'content.link' => 'required',
            'content.price' => 'required|numeric'
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }
        $content['link'] = addsitescheme(ao($content, 'link'));

        $extra = [
            'name' => $request->label
        ];


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
        $cover_size = (int) \Elements::config('link_locker', 'config.cover_size.value');
        $cover_size = "{$cover_size}000";

        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,avi|max:'. $cover_size,
        ]);

        // Image name
        $image = \UserStorage::put('media/element/thumbnail', $request->{$input}, $this->user->id);

        // Return image name
        return $image;
    }
}