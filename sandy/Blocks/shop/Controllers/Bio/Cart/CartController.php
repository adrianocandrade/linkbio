<?php

namespace Sandy\Blocks\shop\Controllers\Bio\Cart;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\StoreSetting;
use Sandy\Blocks\shop\Traits\UserBioShop;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductShipping;

class CartController extends Controller{
    use UserBioShop;

    public function cart(Request $request){
        if (!plan('settings.block_shop', $this->bio->id)) {
            abort(404);
        }
        
        $shipping = ProductShipping::where('user', $this->bio->id)->get();

        return view('Blocks-shop::bio.cart.cart', ['shipping' => $shipping]);
    }


    public function add_item(Request $request){
        $validator = \Validator::make($request->all(), [
            'options' => 'sometimes|required'
        ]);

        if ($validator->fails()) {
            // If it's ajax here...

            return back()->with('error', $validator->errors()->first());
        }


        return \Sandy\Blocks\shop\Helper\Cart::store_cart($this->bio->id, $request);
        return back()->with('success', __('Added to cart.'));
    }


    public function remove_item(Request $request){
        \DarryCart::session($this->bio->id)->remove($request->cart_id);

        return back()->with('success', __('Cart item removed.'));
    }
}