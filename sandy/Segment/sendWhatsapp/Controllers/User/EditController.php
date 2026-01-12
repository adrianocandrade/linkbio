<?php

namespace Sandy\Segment\sendWhatsapp\Controllers\User;

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
            'phone' => 'required',
            'caption' => 'required'
        ]);

        $content = [
            'caption' => $request->caption,
            'phone'     => $request->phone,
            'one_message' => $request->one_message
        ];
        
        $extra = [
            'name' => $request->label
        ];

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}