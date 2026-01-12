<?php

namespace Sandy\Segment\link_locker\Controllers\User;

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
        // Thumbnail
        $thumbnail = [
            'type' => $request->sandy_upload_media_type,
            'upload' => ao($this->element->thumbnail, 'upload'),
            'link' => $request->sandy_upload_media_link
        ];

        if ($process_image = $this->processImage($request, 'sandy_upload_media_upload')) {
            $thumbnail['upload'] = $process_image;
        }

        $extra['thumbnail'] = $thumbnail;

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
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

        if (!empty(ao($this->element->thumbnail, 'upload')) && mediaExists('media/element/thumbnail', ao($this->element->thumbnail, 'upload'))) {
            \UserStorage::remove('media/element/thumbnail', ao($this->element->thumbnail, 'upload')); 
        }

        // Image name
        $image = \UserStorage::put('media/element/thumbnail', $request->{$input}, $this->bio->id);

        // Return image name
        return $image;
    }
}