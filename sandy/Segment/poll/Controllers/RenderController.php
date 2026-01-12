<?php

namespace Sandy\Segment\poll\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;
use Intervention\Image\ImageManagerStatic as Image;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render(Request $request){
        \Elements::makePublic($this->name);

        $overall_choices_total = 0;


        if (is_array($choices = ao($this->element->content, 'choices'))) {
            foreach ($choices as $key => $value) {
                $overall_choices_total += ao($value, 'result');
            }
        }

        $has_vote = $this->has_vote($request);
        $session_key = $this->session_key();


        return view("App-$this->name::render", ['has_vote' => $has_vote, 'overall_choices_total' => $overall_choices_total, 'session_key' => $session_key]);
    }

    public function has_vote($request){
        $session_key = $this->session_key();
        //session()->remove($session_key);

        return $request->session()->exists($session_key) ? true : false;
    }

    public function session_key(){
        $user = $this->bio;
        $element = $this->element;
        $session_key = "{$user->id}_{$element->id}";
        return $session_key;
    }

    public function vote($slug, Request $request){
        if ($this->has_vote($request)) {
            return back()->with('error', __('Can only vote once'));
        }

        $user = $this->bio;
        $element = $this->element;
        $session_key = $this->session_key();
        $content = $element->content;



        if (is_array($choices = ao($content, 'choices'))) {
            if (array_key_exists($request->vote, $choices)) {
                $votes = ao($choices, "$request->vote.result");
                $new_vote = ($votes + 1);

                $content['choices'][$request->vote]['result'] = $new_vote;
                // Has Voted
                session([$session_key => $request->vote]);


                $update = updateElement($this->element->id, $content);
            }
        }




        return back()->with('success', __('Voted'));
    }
}