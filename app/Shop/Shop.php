<?php

namespace App\Shop;
use Illuminate\Http\File;
use App\Models\StoreSetting;

class Shop{
    public static function has_store_setup($user_id){
        if (!$store = StoreSetting::where('user', $user_id)->first()) {
            return false;
        }

        if (!$store->store_setup) {
            return false;
        }

        return true;
    }

    public static function shop_product_item($item){


        return view('bio::include.shop-item', ['item' => $item]);
    }
    public static function order_status($status){

            if ($status == 1) {
                return __('Pending');
            }

            if ($status == 2) {
                return __('Completed');
            }

            if ($status == 3) {
                return __('Canceled');
            }


            return __('Invalid');
    }

    public static function get($key = null, $user = false){
        $user_id = auth()->user()->id ?? null;
        if ($user) {
            $user_id = $user;
        }

        if (!$store = StoreSetting::where('user', $user_id)->first()) {
            return false;
        }


        return ao($store->toArray(), $key);
    }
}