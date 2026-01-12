<?php

namespace Sandy\Segment\giveaway\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'giveaway';
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function create(){
        $skeleton = $this->skeleton();

        // Return
        return view("App-$this->element::create", ['skeleton' => $skeleton]);
    }

    public function createPost(Request $request){
        $elm_check = (new \Elements)->is_in_plan($this->element);
        if (!ao($elm_check, 'status')) {
            return back()->with('error', ao($elm_check, 'message'));
        }
        
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

        $process_image = $this->processImage($request, 'sandy_upload_media_upload');
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
        $image_size = (int) \Elements::config('giveaway', 'config.cover_size.value');
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