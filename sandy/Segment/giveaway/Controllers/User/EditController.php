<?php

namespace Sandy\Segment\giveaway\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function edit($slug){
        $skeleton = $this->skeleton();

        // Return
        return view("App-$this->name::edit", ['skeleton' => $skeleton]);
    }

    public function editPost(Request $request){
        $request->validate([
            'label' => 'required',
            'settings' => 'required'
        ]);

        $content = [
            'caption' => $request->caption
        ];

        if (!empty($request->settings)) {
            foreach ($request->settings as $key => $value) {
                $content[$key] = (bool) $value;
            }
        }

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
        $image_size = (int) \Elements::config('giveaway', 'config.cover_size.value');
        $image_size = "{$image_size}000";

        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|mimes:jpeg,png,jpg,gif,svg,mp4,mov,ogg,avi|max:'. $image_size,
        ]);

        if (!empty(ao($this->element->thumbnail, 'upload')) && mediaExists('media/element/thumbnail', ao($this->element->thumbnail, 'upload'))) {
            \UserStorage::remove('media/element/thumbnail', ao($this->element->thumbnail, 'upload')); 
        }

        // Image name
        $image = \UserStorage::put('media/element/thumbnail', $request->{$input}, $this->bio->id);

        // Return image name
        return $image;
    }

    public function skeleton(){
        return [
            'dob' => [
                'name' => 'Date Of Birth',
                'description' => 'Collect Date Of Birth?'
            ],

            'first_name' => [
                'name' => 'First Name',
                'description' => 'Collect First Name'
            ],

            'last_name' => [
                'name' => 'Last Name',
                'description' => 'Collect Last Name'
            ],

            'phone' => [
                'name' => 'Phone Number',
                'description' => 'Collect Phone Number'
            ],
        ];
    }
}