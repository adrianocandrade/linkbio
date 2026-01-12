<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Shipping;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductShipping;
use Sandy\Blocks\shop\Models\ProductShippingLocation;

class ShippingController extends Controller
{
    public function shipping(){
        $shipping = ProductShipping::where('user', $this->user->id)->get();

        return view('Blocks-shop::mix.shipping.index', ['shipping' => $shipping]);
    }

    public function delete($id){
        $shipping = ProductShipping::where('user', $this->user->id)->where('id', $id)->first();

        if (!$shipping) {
            abort(404);
        }


        $locations = ProductShippingLocation::where('shipping_id', $shipping->id)->delete();

        $shipping->delete();


        return back()->with('success', __('The shipping & locations has been deleted.'));
    }


    public function post_new(Request $request){
        $request->validate([
            'country' => 'required'
        ]);


        $country = \App\Others\Country::list();
        $country = ao($country, "$request->country");

        $shipping = new ProductShipping;
        $shipping->user = $this->user->id;
        $shipping->country_iso = $request->country;
        $shipping->country = $country;
        $shipping->save();

        // Redirect to shipping location


        return redirect()->route('sandy-blocks-shop-mix-shipping-locations', $shipping->id)->with('success', __('Shipping has been saved. Add some locations.'));
    }
}
