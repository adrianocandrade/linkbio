<?php

namespace Sandy\Segment\textarea\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'textarea';

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
            'textarea' => 'required',
        ]);

        $content = [
            'textarea' => $request->textarea
        ];

        $extra = [
            'name' => $request->label
        ];

        $insert = insertElement($this->user->id, $this->element, $content, $extra);


        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }
}