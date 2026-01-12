<?php

namespace Sandy\Segment\email\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Element;

class NewController extends Controller{
    public $element = 'email';

    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function new(){
        return view("App-$this->element::add");
    }

    public function create(Request $request){
        $elm_check = (new \Elements)->is_in_plan($this->element);
        if (!ao($elm_check, 'status')) {
            return back()->with('error', ao($elm_check, 'message'));
        }
        
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

        $insert = insertElement($this->user->id, $this->element, $content, ['name' => $request->label]);

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }
}