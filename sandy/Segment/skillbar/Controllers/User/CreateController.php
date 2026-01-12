<?php

namespace Sandy\Segment\skillbar\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class CreateController extends Controller{
    public $element = 'skillbar';
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
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }


        $skills = [];

        if (!empty($request->skills)) {
            foreach ($request->skills as $key => $value) {
                $validator = \Validator::make(['name' => ao($value, 'name'), 'skill' => ao($value, 'skill')], ['name' => 'min:1|required|string', 'skill' => 'required|numeric|min:1|max:100']);


                $validator->validate();

                $skills[$key] = $value;
            }
        }
        $content['skills'] = $skills;

        $extra = [
           'name' => $request->label
        ];

        $insert = insertElement($this->user->id, $this->element, $content, $extra);

        // Return to elements
        return redirect()->route('user-mix-pages')->with('success', __('Saved Successfully'));
    }
}