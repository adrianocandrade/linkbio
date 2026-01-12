<?php

namespace Sandy\Blocks\shop\Controllers\Mix\Shipping;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductShipping;
use Sandy\Blocks\shop\Models\ProductShippingLocation;

class LocationsController extends Controller
{
    public function locations($id){
        $shipping = ProductShipping::where('id', $id)->where('user', $this->user->id)->first();
        if (!$shipping) {
            abort(404);
        }

        $locations = ProductShippingLocation::where('shipping_id', $shipping->id)->where('user', $this->user->id)->get();

        return view('Blocks-shop::mix.shipping.locations', ['shipping' => $shipping, 'locations' => $locations]);
    }

    public function post($id, Request $request){
        $shipping_country = ProductShipping::where('id', $id)->where('user', $this->user->id)->first();
        if (!$shipping_country) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:200',
            'price'       => 'sometimes|required'
        ]);


        $shipping = new ProductShippingLocation;
        $shipping->user = $this->user->id;
        $shipping->shipping_id = $shipping_country->id;
        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->price = $request->price;
        $shipping->save();


        return back()->with('success', __('Location saved successfully.'));
    }

    public function edit(Request $request){
        if (!$shipping = ProductShippingLocation::where('id', $request->id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|max:50',
            'description' => 'required|max:200',
            'price'       => 'sometimes|required'
        ]);


        $shipping->name = $request->name;
        $shipping->description = $request->description;
        $shipping->price = $request->price;
        $shipping->update();


        return back()->with('success', __('Location updated successfully.'));
    }


    public function delete($id){
        if (!$shipping = ProductShippingLocation::where('id', $id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $shipping->delete();


        return back()->with('success', __('Location deleted successfully.'));
    }
}
