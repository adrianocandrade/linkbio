<?php

namespace Sandy\Segment\tipJar\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class EditController extends Controller{
    public $name = 'tipJar';

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
        ]);


        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }


        $amounts = [];

        if (!empty($request->amounts)) {
            foreach ($request->amounts as $key => $value) {
                $validator = \Validator::make(['price' => ao($value, 'price')], ['price' => 'min:1|required|numeric']);


                $validator->validate();

                $amounts[$key] = $value;
            }
        }
        $content['amounts'] = $amounts;
        $extra = [
            'name' => $request->label
        ];

        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }
}