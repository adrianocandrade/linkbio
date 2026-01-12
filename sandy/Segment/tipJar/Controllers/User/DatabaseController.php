<?php

namespace Sandy\Segment\tipJar\Controllers\User;

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
        return redirect()->route('user-mix-tips');


        $db = Elementdb::where('element', $this->element->id)->orderBy('id', 'DESC')->get();

        return view("App-$this->name::database", ['db' => $db]);
    }
}