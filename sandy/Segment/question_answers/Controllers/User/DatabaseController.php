<?php

namespace Sandy\Segment\question_answers\Controllers\User;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Models\Elementdb;

class DatabaseController extends Controller{
    function __construct(){
        parent::__construct();
        $this->middleware('auth');
    }

    public function database($slug){
        $db = Elementdb::where('element', $this->element->id)->orderBy('id', 'DESC')->get();

        return view("App-$this->name::database", ['db' => $db]);
    }
}