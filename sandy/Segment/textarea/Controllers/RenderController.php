<?php

namespace Sandy\Segment\textarea\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render(){
        // \Route::getRoutes()->getByName('sandy-app-textarea-edit')->getActionName();
        return view("App-$this->name::render");
    }
}