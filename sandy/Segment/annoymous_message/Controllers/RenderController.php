<?php

namespace Sandy\Segment\annoymous_message\Controllers;

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
        return view("App-$this->name::render");
    }

    public function sendMessage($slug, Request $request){
        $request->validate([
            'text'  => 'required'
        ]);

        $db = [
            'text'  => $request->text
        ];

        // Check if to send message once

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();

        // Redirect
        return back()->with('success', __('Message Submitted Successfully'));
    }
}