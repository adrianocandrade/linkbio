<?php

namespace Sandy\Segment\page_review\Controllers\User;

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
            'content.caption' => 'required'
        ]);

        $content = [];

        if (!empty($request->content)) {
            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        $extra = [
            'name' => $request->label
        ];


        $update = updateElement($this->element->id, $content, $extra);

        // Return to elements
        return back()->with('success', __('Saved Successfully'));
    }


    public function accept_review($slug, $id){
        if (!$element_db = \App\Models\Elementdb::where('id', $id)->where('element', $this->element->id)->first()) {
            abort(404);
        }


        $database = $element_db->database;
        $database['status'] = 1;

        $element_db->database = $database;
        $element_db->save();

        return redirect()->route('sandy-app-page_review-database', $this->element->slug)->with('success', __('Status changed.'));
    }
}