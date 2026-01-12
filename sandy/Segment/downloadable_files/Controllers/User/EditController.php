<?php

namespace Sandy\Segment\downloadable_files\Controllers\User;

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
            'content.price.price' => 'numeric',
            'content.price.min_price' => 'numeric',
            'content.price.suggest_price' => 'numeric'
        ]);

        $content = $this->element->content;

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
        $image_size = (int) \Elements::config('downloadable_files', 'config.image_size.value');
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



    public function addDownloadables(Request $request){
        $size = (int) \Elements::config('downloadable_files', 'config.file_size.value');
        $size = "{$size}000";
        $formats = \Elements::config('downloadable_files', 'config.file_size.formats');
        $max_file = (int) \Elements::config('downloadable_files', 'config.max_files.value');
        $content = $this->element->content;

        if (is_array(ao($content, 'downloadables')) && count(ao($content, 'downloadables')) >= $max_file) {
            return back()->with('error', __('Exceeded the maximum allowed file(s) of "'. $max_file .'".'));
        }


        // Validate image
        $request->validate([
            'downloadable_files' => 'required|mimes:'. $formats .'|max:'. $size,
        ]);

        $pathinfo = pathinfo($request->file('downloadable_files')->getClientOriginalName());
        $filename = slugify(ao($pathinfo, 'filename'));
        $name = $filename .'_'. strtolower(\Str::random(3)) .'.'. ao($pathinfo, 'extension');

        $file = \UserStorage::putAs('media/element/others', $request->downloadable_files, $name, $this->bio->id);


        $content['downloadables'][] = $file;
        $update = updateElement($this->element->id, $content);


        return back()->with('success', __('Downloadables added.'));
    }


    public function deleteDownloadables($slug, Request $request){
        if (!is_array($downloadables = ao($this->element->content, 'downloadables'))) {
            return back()->with('error', __('Could not find file'));
        }


        if (mediaExists('media/element/others', $request->downloadable)) {
            \UserStorage::remove('media/element/others', $request->downloadable);

            $content = $this->element->content;

            foreach ($downloadables as $key => $value) {
                if ($request->downloadable == $value) {
                    unset($content['downloadables'][$key]);
                }
            }

            $update = updateElement($this->element->id, $content);

            return back()->with('success', __('File removed successfully'));
        }
        
        return back()->with('error', __('Could not find file'));
    }
}