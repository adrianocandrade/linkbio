<?php

namespace Sandy\Segment\guestbook\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function edit(){
        return view("App-$this->name::edit");
    }

    public function editPost($slug, Request $request){
        $request->validate([
            'name' => 'required|max:60',
            'description' => 'max:200'
        ]);

        $content = [
            'title' => $request->name,
            'description' => $request->description
        ];
        
        $extra = [
           'name' => $request->name
        ];

        $insert = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}