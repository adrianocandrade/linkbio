<?php

namespace App\Traits;
use Illuminate\Http\Request;
use App\Traits\UserBioInfo;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use App\Models\ProductOrder;

trait UserBioShop {
    use UserBioInfo;



    public function has_purchased($bio_id, $product_id){
        if (!$payee = \Auth::user()) {
            return false;
        }

        $order = ProductOrder::where('user', $bio_id)->where('payee_user_id', $payee->id)->get();


        foreach ($order as $item) {
           if (in_array($product_id, $item->products)) {
               return true;
           }
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