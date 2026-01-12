<?php

namespace Sandy\Segment\downloadable_files\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'downloadable_files';
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
            'content.price.price' => 'numeric',
            'content.price.min_price' => 'numeric',
            'content.price.suggest_price' => 'numeric',
            'downloadable_files' => 'required'
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        if (!ao($content, 'price.type')) {
            $request->validate(['content.price.min_price' => 'required|min:1|numeric']);
        }

        $extra = [
           'name' => $request->label
        ];

        $content['downloadables'][] = $this->downloadables($request);


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
        $image_size = (int) \Elements::config('downloadable_files', 'config.image_size.value');
        $image_size = "{$image_size}000";

        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|mimes:jpeg,png,jpg,gif,mp4,mov,ogg,avi|max:'. $image_size,
        ]);

        // Image name
        $image = \UserStorage::put('media/element/thumbnail', $request->{$input}, $this->user->id);

        // Return image name
        return $image;
    }

    private function downloadables($request){
        $size = (int) \Elements::config('downloadable_files', 'config.file_size.value');
        $size = "{$size}000";
        $formats = \Elements::config('downloadable_files', 'config.file_size.formats');

        if (empty($request->downloadable_files)) {
            return false;
        }

        // Validate image
        $request->validate([
            'downloadable_files' => 'required|mimes:'. $formats .'|max:'. $size,
        ]);

        $pathinfo = pathinfo($request->file('downloadable_files')->getClientOriginalName());
        $filename = slugify(ao($pathinfo, 'filename'));
        $name = $filename .'_'. strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

        $file = \UserStorage::putAs('media/element/others', $request->downloadable_files, $name, $this->user->id);

        // Return image name
        return $file;
    }
}