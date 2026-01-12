<?php

namespace Sandy\Segment\question_answers\Controllers;

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

    public function ask($slug, Request $request){
        if (ao($this->element->content, 'price.enable') == 'enable') {
            return back()->with('error', __('Please pay to ask a question'));
        }

        $this->private_ask($request);

        // Redirect
        return back()->with('success', __('Question has been asked. Please wait for response.'));
    }

    public function private_ask($request){

        $request->validate([
            'question'  => 'required'
        ]);
        $status = 1;

        if (!ao($this->element->content, 'show_unanswered')) {
            $status = 0;
        }

        $db = [
            'question' => $request->question,
            'name'  => $request->name,
            'status' => $status
        ];

        // Check if to send message once

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();
    }

    public function pay_to_ask($slug, Request $request){
        $request->validate([
            'email'  => 'required|email'
        ]);
        // Prices
        $price = ao($this->element->content, 'price.price');

        // Payment
        $payment = new Payments();
        // SxRef
        $sxref = md5(microtime());
        // Method
        $method = ao($this->bio->payments, 'default');
        // Keys
        $keys = user("payments.$method", $this->bio->id);

        //
        $callback = route('sandy-app-question_answers-pay-callback', ['slug' => $this->element->slug, 'sxref' => $sxref]);

        $meta = [
            'bio' => $this->bio->id,
            'element' => $this->element->id
        ];

        $data = [
            'method' => $method,
            'price' => $price,
            'email' => $request->email,
            'callback' => $callback,
            'currency' => ao($this->bio->payments, 'currency')
        ];


        $create = $payment->create($sxref, $data, $keys, $meta);

        // Return the gateway
        return $create;
    }


    public function pay_callback($slug, Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if ($payment = Payments::is_paid($sxref)) {
            if (ao($payment->meta, 'bio') !== $this->bio->id) {
                abort(404);
            }

            if ($payment->created_at->diffInHours(\Carbon\Carbon::now()) <= 3) {
                


                return view("App-$this->name::render-unlocked");
            }


            return fancy_error(__('Elements'), __("Payment for this element is expired."));
        }


        return fancy_error(__('General Error'), __("Unable to verify payment. Please try again."));
    }

    public function paid_question_ask($slug, Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if ($payment = Payments::is_paid($sxref)) {
            if (ao($payment->meta, 'bio') !== $this->bio->id) {
                abort(404);
            }


            if ($payment->created_at->diffInHours(\Carbon\Carbon::now()) <= 3) {
                


                $this->private_ask($request);
                // Redirect
                return redirect()->route('sandy-app-question_answers-render', $slug)->with('success', __('Question has been asked. Please wait for response.'));
            }


            return fancy_error(__('Elements'), __("Payment for this element is expired."));
        }


        return fancy_error(__('General Error'), __("Unable to verify payment. Please try again."));

    }
}