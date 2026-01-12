<?php

namespace Sandy\Segment\poll\Controllers\User;

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
        $overall_choices_total = 0;

        if (is_array($choices = ao($this->element->content, 'choices'))) {
            foreach ($choices as $key => $value) {
                $overall_choices_total += ao($value, 'result');
            }
        }

        $db = Elementdb::where('element', $this->element->id)->orderBy('id', 'DESC')->get();

        return view("App-$this->name::database", ['db' => $db, 'overall_choices_total' => $overall_choices_total]);
    }
}