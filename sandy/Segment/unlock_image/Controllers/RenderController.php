<?php

namespace Sandy\Segment\unlock_image\Controllers;

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

    public function render(){
        //\Elements::makePublic($this->name);
        return view("App-$this->name::render");
    }


    public function getBluredImage(){
        try {
            $image_to_be_unlocked = media_or_url($this->element->thumbnail, 'media/element/thumbnail');
            header('Content-type: image/jpeg');

            $content = file_get_contents($image_to_be_unlocked);

            $image = new \Imagick();
            $image->readImageBlob($content);

            $image->blurImage(70,70);

            return $image;
        } catch (\Exception $e) {
            
        }


        return false;
    }

    public function unlockPayment($slug, Request $request){
        $request->validate([
            'email'  => 'required|email'
        ]);

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
        // Prices
        $price = ao($this->element->content, 'price');
        // Method
        $method = ao($this->bio->payments, 'default');
        // Keys
        $keys = user("payments.$method", $this->bio->id);

        //
        $callback = route('sandy-app-unlock_image-unlock-callback', ['slug' => $this->element->slug, 'sxref' => $sxref]);

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


    public function unlock_callback($slug, Request $request){
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