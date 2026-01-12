<?php

namespace Sandy\Segment\downloadable_files\Controllers;

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

    public function purchase($slug, Request $request){
        $request->validate([
            'email'  => 'required|email'
        ]);
        // Prices
        $price = ao($this->element->content, 'price.price');

        if (!ao($this->element->content, 'price.type')) {
            $min_price = ao($this->element->content, 'price.min_price');

            $request->validate(['amount' => "required|min:$min_price|numeric"]);
            $price = $request->amount;
        }

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
        $callback = route('sandy-app-downloadable_files-purchase-callback', ['slug' => $this->element->slug, 'sxref' => $sxref]);

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


    public function purchase_callback($slug, Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if ($payment = Payments::is_paid($sxref)) {
            if (ao($payment->meta, 'bio') !== $this->bio->id) {
                abort(404);
            }

            $database = Elementdb::find(ao($payment->meta, 'database'));

            if ($database) {
                $db = $database->database;
                $db['status'] = 1;

                $database->database = $db;
                $database->save();
            }

            if ($payment->created_at->diffInHours(\Carbon\Carbon::now()) <= 3) {
                


                return view("App-$this->name::render-unlocked");
            }


            return fancy_error(__('Elements'), __("Payment for this element is expired."));
        }


        return fancy_error(__('General Error'), __("Unable to verify payment. Please try again."));
    }
}