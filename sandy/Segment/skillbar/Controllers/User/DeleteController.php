<?php

namespace Sandy\Segment\skillbar\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Models\Elementdb;
use App\Models\Element;

class DeleteController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function delete($slug){
        $element = Element::find($this->element->id);

        $name = $element->name;


        if (mediaExists('media/element/thumbnail', ao($element->thumbnail, 'upload'))) {
            \UserStorage::remove('media/element/thumbnail', ao($element->thumbnail, 'upload'));
        }


        if (is_array($downloadables = ao($this->element->content, 'downloadables'))) {
            foreach ($downloadables as $key => $value) {
                if (mediaExists('media/element/others', $value)) {
                    \UserStorage::remove('media/element/others', $value);
                }
            }
        }


        $db = Elementdb::where('element', $element->id)->delete();

        // Delete
        $element->delete();

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('":element" Deleted Successfully.', ['element' => $name]));
    }
}