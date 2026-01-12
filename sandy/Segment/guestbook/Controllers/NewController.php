<?php

namespace Sandy\Segment\guestbook\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Element;

class NewController extends Controller{
    public $element = 'guestbook';

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

        $insert = insertElement($this->user->id, $this->element, $content, $extra);

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }
}