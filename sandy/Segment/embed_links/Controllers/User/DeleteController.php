<?php

namespace Sandy\Segment\embed_links\Controllers\User;

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

        $db = Elementdb::where('element', $element->id)->delete();

        // Delete
        $element->delete();

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __(':element Deleted Successfully.', ['element' => $name]));
    }
}