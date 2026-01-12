<?php

namespace Sandy\Segment\question_answers\Controllers\User;

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

    public function respond($slug, Request $request){
        if (!$element_db = \App\Models\Elementdb::where('id', $request->id)->where('element', $this->element->id)->first()) {
            abort(404);
        }

        $request->validate([
            'response' => 'required'
        ]);


        $database = $element_db->database;
        $database['response'] = $request->response;

        $element_db->database = $database;
        $element_db->save();

        return redirect()->route('sandy-app-question_answers-database', $this->element->slug)->with('success', __('Response added.'));
    }

    public function editPost(Request $request){
        $request->validate([
            'label' => 'required',
            'content.description' => 'required',
            'content.price.price' => 'numeric|min:1'
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
        $image_size = (int) \Elements::config('question_answers', 'config.cover_size.value');
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
}