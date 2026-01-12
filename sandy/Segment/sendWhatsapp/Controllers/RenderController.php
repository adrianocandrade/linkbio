<?php

namespace Sandy\Segment\sendWhatsapp\Controllers;

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

    public function has_send_message($request){
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

    public function sendMessage($slug, Request $request){
        $session_key = $this->session_key();
        $request->validate([
            'text'  => 'required'
        ]);

        $db = [
            'text'  => $request->text
        ];

        // Check if to send message once

        if (ao($this->element->content, 'one_message') && $this->has_send_message($request)) {

            return redirect()->route('sandy-app-sendWhatsapp-render', ['slug' => $slug])->with('info', __('Can only send message once.'));

            //
            return back()->with('info', __('Can only send message once.'));
        }

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();
        session([$session_key => true]);

        $phone = ao($this->element->content, 'phone');
        $redirect = "https://wa.me/$phone?text=$request->text";

        // Redirect
        return redirect($redirect);
    }
}