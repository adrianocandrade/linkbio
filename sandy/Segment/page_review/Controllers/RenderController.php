<?php

namespace Sandy\Segment\page_review\Controllers;

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
        \Elements::makePublic($this->name);
        return view("App-$this->name::render");
    }

    public function leaveReview($slug, Request $request){
        $request->validate([
            'name' => 'required',
            'review'  => 'required'
        ]);
        $status = 0;
        $rating = null;

        if (ao($this->element->content, 'auto_accept')) {
            $status = 1;
        }
        if (ao($this->element->content, 'enable_rating')) {
            $request->validate(['rating' => 'required|max:5|min:1|numeric']);
            $rating = $request->rating;
        }


        $db = [
            'status' => $status,
            'rating' => $rating,
            'name' => $request->name,
            'review'  => $request->review
        ];

        // Check if to send message once

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();

        // Redirect
        return back()->with('success', __('Review Submitted Successfully'));
    }
}