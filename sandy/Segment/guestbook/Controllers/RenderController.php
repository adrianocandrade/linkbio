<?php

namespace Sandy\Segment\guestbook\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Models\Element;
use App\Models\Elementdb;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render($slug){
        return view("App-$this->name::render");
    }

    public function postList($slug, Request $request){

        $request->validate([
            'content' => 'required|max:200'
        ]);

        $key = \Str::random(5);
        $db = [
            'status' => 1,
            'content' => $request->content,
            'color' => $request->color,
        ];

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();


        return back()->with('success', __('Posted Successfully'));
    }
}