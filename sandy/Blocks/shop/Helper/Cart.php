<?php

namespace Sandy\Blocks\shop\Helper;
use Illuminate\Http\File;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOption;

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


        if (isset($request->membership_price)) {
            $price = ao($product->extra, "price_$request->membership_price");
        }

        $price = (int) $price;


        // Check for quantity availabilty
        if (!empty($options_request = $request->options)) {

            if ($variant = ProductOption::find($options_request)) {
                $options = [
                    'id'    => $variant->id,
                    'name' => $variant->name,
                ];

                $price = $variant->price;
                $stock = $variant->stock;

                if (isset($request->membership_price)) {
                    $price = (int) $variant->price + ao($product->extra, "price_$request->membership_price");
                }
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
                'membership' => [
                    'status' => isset($request->membership_price) ? true : false,
                    'type' => isset($request->membership_price) ? $request->membership_price : null,
                    'expire' => isset($request->membership_price) ? ($request->membership_price == 'monthly' ? \Carbon\Carbon::now()->addMonths(1) : \Carbon\Carbon::now()->addMonths(12)) : false
                ]
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
            return view('Blocks-shop::bio.include.cart-item', ['cart' => $items]);
        }

        return $items;
    }
}