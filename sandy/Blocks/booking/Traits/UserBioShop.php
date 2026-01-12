<?php

namespace Sandy\Blocks\shop\Traits;
use Illuminate\Http\Request;
use App\Traits\UserBioInfo;
use Illuminate\Support\Facades\View;
use Sandy\Blocks\shop\Models\ProductOrder;
use Sandy\Blocks\shop\Models\Product;

trait UserBioShop {
    use UserBioInfo;



    public function has_purchased($bio_id, $product_id){
        if (!$payee = \Auth::user()) {
            return false;
        }

        $order = ProductOrder::where('user', $bio_id)->where('payee_user_id', $payee->id);

        $has_order = function() use($order, $product_id){
            foreach ($order->get() as $item) {
               if (in_array($product_id, $item->products)) {
                   return true;
               }
            }


            return false;
        };

        $enrollment = ProductOrder::where('user', $bio_id)->where('payee_user_id', $payee->id)->orderBy('id', 'DESC')->first();
        $now = \Carbon\Carbon::now();
        if ($has_order() && $enrollment) {
            if (is_array(ao($enrollment->extra, 'cart'))) {

                // code...


                foreach (ao($enrollment->extra, 'cart') as $key => $value) {
                    $product = \Sandy\Blocks\shop\Models\Product::find(ao($value, 'attributes.product_id'));

                    if ($product->price_type == 2  && ao($value, 'attributes.product_id') == $product_id) {

                        $expiry = \Carbon\Carbon::parse(ao($value, 'attributes.membership.expire'));
                        $expired = \Carbon\Carbon::parse($now)->isAfter($expiry);

                        if (ao($value, 'attributes.membership.status') && !$expired) {
                            return true;
                        }

                        return false;
                    }
                }
            }
        }

        if ($has_order()) {
            return true;
        }


        return false;
    }


    public function user_orders($bio_id, $product_id){
        if (!$payee = \Auth::user()) {
            return false;
        }

        $order = ProductOrder::where('user', $bio_id)->where('payee_user_id', $payee->id)->orderBy('id', 'DESC')->get();

        $orders = [];

        foreach ($order as $item) {
           if (in_array($product_id, $item->products)) {
                $orders[] = $item;
           }
        }


        return $orders;
    }
}