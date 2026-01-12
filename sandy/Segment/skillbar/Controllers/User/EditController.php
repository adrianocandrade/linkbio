<?php

namespace Sandy\Segment\skillbar\Controllers\User;

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

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}