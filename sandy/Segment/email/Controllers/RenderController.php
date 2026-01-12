<?php

namespace Sandy\Segment\email\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Models\Element;
use App\Models\Elementdb;

class RenderController extends Controller{
    public $name = 'email';

    function __construct(){
        parent::__construct();
    }

    public function render($slug){
        return view("App-$this->name::render");
    }

    public function postSubmission($slug, Request $request){

        $request->validate([
            'email' => 'required'
        ]);
        $key = [
            'email' => $request->email,
        ];


        if (ao($this->element->content, 'require_name')) {
            $request->validate([
                'first_name' => 'required',
                'last_name' => 'required'
            ]);

            $key['first_name'] = $request->first_name;
            $key['last_name'] = $request->last_name;
        }

        $db = $key;


        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->email = $request->email;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();


        return back()->with('success', __('Thanks for signing up to our email list.'));
    }
}