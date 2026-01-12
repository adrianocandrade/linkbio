<?php

namespace Sandy\Segment\textarea\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    public $name = 'textarea';

    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function edit($slug){
        // \Route::getRoutes()->getByName('sandy-app-textarea-edit')->getActionName();
        return view("App-$this->name::edit");
    }

    public function editPost(Request $request){
        $request->validate([
            'label' => 'required',
            'textarea' => 'required',
        ]);

        $content = [
            'textarea' => $request->textarea
        ];

        $extra = [
            'name' => $request->label
        ];

        $insert = updateElement($this->element->id, $content, $extra);


        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}