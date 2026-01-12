<?php

namespace App\Shop;
use Illuminate\Http\File;
use App\Models\StoreSetting;
use App\Models\Product;
use App\Models\ProductOption;

class Cart{
    public static function store_cart($user_id, $request){
        $options = [];


        $product = Product::where('user', $user_id)->where('id', $request->product_id)->first();

        $stock = $product->stock;

        if (!$product) {
            return false;
        }

        $quantity = 1;

        // Check if is paywhat you want
        $price = $product->price;
        $price = (int) $price;


        // Check for quantity availabilty
        if (!empty($options_request = $request->options)) {

            if ($variant = ProductOption::find($options_request)) {
                $price = $variant->price;
                $options = [
                    'id'    => $variant->id,
                    'name' => $variant->name,
                ];

                $stock = $variant->stock;
            }

            // Check for quntity
        }



        // Check for stock availabilty
        if (ao($product->stock_settings, 'enable')) {
            // Check for product stock
            $request->validate([
                'quantity' => 'required|numeric|max:' . $stock
            ]);
            $quantity = $request->quantity;
        }

        $id = md5("product_id.{$product->id}.{$price}:options." . serialize(array_filter($options)));

        $cart = \DarryCart::session($user_id)->add([
            'id' => $id,
            'name' => $product->name,
            'price' => $price,
            'quantity' => $quantity,
            'attributes' => [
                'product_id' => $product->id,
                'options' => $options,
            ],
            'associatedModel' => $product
        ]);


        return back()->with('success', __('Added to cart.'));
    }


    public function get_cart($user_id, $html = false){
        $items = \DarryCart::session($user_id)->getContent();


        foreach ($items as $item) {
            $product = Product::where('user', $user_id)->where('id', ao($item->attributes, 'product_id'))->first();
            if ($product) {
                $stock = $product->stock;
            }

            if ($option = ProductOption::find(ao($item, 'attributes.options.id'))) {
                $stock = $option->stock;
            }

            if ($product && ao($product->stock_settings, 'enable')) {

                if ($item->quantity > $stock) {
                    \Session::flash('info', __(':product quantity is more than available stock.', ['product' => $item->name]));
                    \DarryCart::session($user_id)->remove($item->id);
                }
            }
        }

        if ($html) {
            return view('bio::include.cart-item', ['cart' => $items]);
        }

        return $items;
    }
}