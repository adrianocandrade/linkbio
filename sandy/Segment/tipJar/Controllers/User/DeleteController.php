<?php

namespace Sandy\Segment\tipJar\Controllers\User;

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


        if (mediaExists('media/element/thumbnail', ao($element->thumbnail, 'thumbnail'))) {
            storageDelete('media/element/thumbnail', ao($element->thumbnail, 'thumbnail'));
        }

        $db = Elementdb::where('element', $element->id)->delete();

        // Delete
        $element->delete();

        // Return to elements
        return redirect()->route('user-mix')->with('success', __('":element" deleted Successfully.', ['element' => $name]));
    }
}