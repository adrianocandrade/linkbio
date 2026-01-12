<?php

namespace Sandy\Segment\embed_links\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render(){
        //\Elements::makePublic($this->name);
        return view("App-$this->name::render");
    }
}