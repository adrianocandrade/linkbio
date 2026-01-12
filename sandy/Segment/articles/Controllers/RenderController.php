<?php

namespace Sandy\Segment\articles\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use App\Element\Render as Controller;
use App\Payments;
use App\Models\Elementdb;

class RenderController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function render($slug, Request $request){
        //\Elements::makePublic($this->name);


        $paywall_content = $this->content($request);
        return view("App-$this->name::render", ['paywall_content' => $paywall_content]);
    }

    public function purchase($slug, Request $request){
        $request->validate([
            'email'  => 'required|email'
        ]);
        // Prices
        $price = ao($this->element->content, 'paywall.price');

        $db = [
            'email' => $request->email,
        ];

        $database = new Elementdb;
        $database->user = $this->bio->id;
        $database->email = $request->email;
        $database->element = $this->element->id;
        $database->database = $db;
        $database->save();

        // Payment
        $payment = new Payments();
        // SxRef
        $sxref = md5(microtime());
        // Method
        $method = ao($this->bio->payments, 'default');
        // Keys
        $keys = user("payments.$method", $this->bio->id);

        //
        $callback = route('sandy-app-articles-render', ['slug' => $this->element->slug, 'sxref' => $sxref]);

        $meta = [
            'bio' => $this->bio->id,
            'element' => $this->element->id,
            'database' => $database->id
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


    public function content($request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        $content = truncate_html(clean(ao($this->element->content, 'description'), 'titles'), ao($this->element->content, 'paywall.limit_words'));
        $is_unlocked = false;

        $returned = [
            'is_unlocked' => $is_unlocked,
            'content' => $content
        ];


        if ($payment = Payments::is_paid($sxref)) {
            if (ao($payment->meta, 'bio') !== $this->bio->id) {
                return $returned;
            }

            if (ao($payment->meta, 'element') !== $this->element->id) {
                return $returned;
            }

            $database = Elementdb::find(ao($payment->meta, 'database'));
            if ($database) {
                $db = $database->database;
                $db['status'] = 1;

                $database->database = $db;
                $database->save();
            }

            if ($payment->created_at->diffInHours(\Carbon\Carbon::now()) <= 9) {
                $returned = [
                    'is_unlocked' => true,
                    'content' => clean(ao($this->element->content, 'description'), 'titles')
                ];
            }
        }


        return $returned;
    }
}