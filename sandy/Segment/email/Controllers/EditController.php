<?php

namespace Sandy\Segment\email\Controllers;

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
            'title' => 'required',
        ]);

        $content = [
            'title' => $request->title,
            'require_name' => $request->require_name,
            'disclaimer' => $request->disclaimer,
            'description' => $request->description
        ];
        
        $extra = [
            'name' => $request->label
        ];

        $update = updateElement($this->element->id, $content, $extra);
        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}