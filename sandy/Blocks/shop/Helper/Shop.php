<?php

namespace Sandy\Blocks\shop\Helper;
use Illuminate\Http\File;

class Shop{
    public static function shop_product_item($item){


        return view('Blocks-shop::bio.include.shop-item', ['item' => $item]);
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
}