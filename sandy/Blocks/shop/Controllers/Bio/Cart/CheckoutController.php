<?php

namespace Sandy\Blocks\shop\Controllers\Bio\Cart;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Sandy\Blocks\shop\Models\Product;
use Sandy\Blocks\shop\Models\ProductOrder;
use Sandy\Blocks\shop\Models\ProductOrderTimeline;
use Sandy\Blocks\shop\Models\ProductOption;
use App\Payments;

class CheckoutController extends Controller{

    public $rules = [
        'email' => 'required'
    ];

    public function checkout(Request $request){
        $payment = new Payments();

        $this->validate($request, $this->rules);


        if (\DarryCart::session($this->bio->id)->isEmpty()) {
            return back()->with('bio_error', ['error' => __('Cart is empty'), 'response' => __('Add items to cart to proceed')]);
        }

        $products = [];

        $cart = [];

        $session_cart = \DarryCart::session($this->bio->id)->getContent()->toArray();

        foreach ($session_cart as $key => $item) {
            $cart[$key] = (array) $item;
            $products[] = ao($item, 'attributes.product_id');
            unset($cart[$key]['associatedModel']);
        }

        $shipping = [];

        // Condition shipping
        if ($shipping_loop = $request->shipping) {
            foreach ($shipping_loop as $key => $value) {
                $shipping[$key] = $value;
            }
        }

        // Cart
        $price = $this->total_price($request);
        $sxref = \Bio::sxref();
        $method = ao($this->bio->payments, 'default');

        $callback = \Bio::route($this->bio->id, 'sandy-blocks-shop-cart-callback', ['sxref' => $sxref]);

        $item = [
            'name' => __(':num_of_product Products', ['num_of_product' => count((new \Sandy\Blocks\shop\Helper\Cart)->get_cart($this->bio->id))]),
            'description' => __('Purchased :num_of_product product(s) on :page', ['page' => $this->bio->name, 'num_of_product' => count((new \Sandy\Blocks\shop\Helper\Cart)->get_cart($this->bio->id))])
        ];

        $meta = [
            'bio_id' => $this->bio->id,
            'item' => $item,
            'cart' => $cart,
            'shipping' => $shipping,
            'payee_id' => \Auth::check() ? \Auth::user()->id : null,
            'workspace_id' => $this->workspace->id ?? null, // Capture workspace ID
            'shipping_location' => $this->shipping_array($request),
            'products' => $products
        ];

        $data = [
            'method' => $method,
            'email' => $request->email,
            'price' => $price,
            'callback' => $callback,
            'currency' => ao($this->bio->payments, 'currency')
        ];
        $keys = user("payments.$method", $this->bio->id);

        $create = $payment->create($sxref, $data, $keys, $meta);

        // Return the gateway
        return $create;
    }

    private function shipping_array($request){
        // Get Shipping Price
        if ($location = \Sandy\Blocks\shop\Models\ProductShippingLocation::where('id', $request->shipping_location)->where('user', $this->bio->id)->first()) {

            $ship = \Sandy\Blocks\shop\Models\ProductShipping::where('id', $location->shipping_id)->first();

            $shipping = [
                'id' => $location->id,
                'iso_country'  => $ship->country_iso,
                'country' => $ship->country,
                'location_name' => $location->name,
                'location_description' => $location->description
            ];

            return $shipping;
        }

        return 'No Shipping';
    }


    private function total_price($request){
        $price = \DarryCart::session($this->bio->id)->getTotal();

        if (user('settings.store.shipping.enable', $this->bio->id) && user('settings.store.shipping.type', $this->bio->id)) {
            $request->validate([
                'shipping_location' => 'required',
                'shipping.*' => 'required'
            ]);
        }

        // Get Shipping Price
        if ($location = \Sandy\Blocks\shop\Models\ProductShippingLocation::where('id', $request->shipping_location)->where('user', $this->bio->id)->first()) {
            $price = ($price + $location->price);
        }

        return $price;
    }


    public function callback(Request $request){
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if (!$spv = Payments::is_paid($sxref)) {
            abort(404);
        }


        // Order
        $this->order($this->bio->id, ao($spv->meta, 'payee_id'), $spv);

        // Send Email - FIX
        $return = \Bio::route($this->bio->id, 'home');

        return redirect($return)->with('success', ao($spv->meta, 'item.description'));
    }

    private function order($user_id, $payee_id, $spv){
        $details = [
            'shipping' => ao($spv->meta, 'shipping'),
            'shipping_location' => ao($spv->meta, 'shipping_location')
        ];

        $extra = [
            'cart' => ao($spv->meta, 'cart')
        ];

        $order = new ProductOrder;
        $order->user = $user_id;
        $order->payee_user_id = $payee_id;
        $order->email = $spv->email;
        $order->price = $spv->price;
        $order->details = $details;
        $order->currency = $spv->currency;
        $order->ref = $spv->method_ref;
        $order->extra = $extra;
        $order->products = ao($spv->meta, 'products');
        $order->status = 1;
        $order->save();

        $order->save();

        // INTEGRATION: AUDIENCE SERVICE
        try {
            // Get workspace from meta or fallback to current context
            $workspaceId = ao($spv->meta, 'workspace_id') ?? 
                          ($this->workspace->id ?? null) ?? 
                          (\App\Models\Workspace::where('user_id', $user_id)->where('is_default', 1)->first()->id ?? null);
            
            // Get phone from shipping/order details if available
            $phone = null;
            if (isset($order->details['shipping']['phone'])) {
                $phone = $order->details['shipping']['phone'];
            }

            $audienceService = app(\Modules\Mix\Services\AudienceService::class);
            $contact = $audienceService->createOrUpdateContact([
                'workspace_id' => $workspaceId,
                'user_id' => $user_id,
                'name' => $request->shipping['name'] ?? $order->email, // Try to find name in shipping details
                'email' => $order->email,
                'phone' => $phone,
                'source' => 'shop',
                'source_id' => $order->id,
            ]);

            $audienceService->recordInteraction(
                $contact->id,
                'purchase',
                'completed',
                $order->price
            );
        } catch (\Exception $e) {
            \Log::error('Audience Integration Error (Shop): ' . $e->getMessage());
        }

        // Add TimeLine

        $timeline = [
            'title' => __('Order Created'),
            'amount' => $spv->price,
            'user_name' => user('name', $payee_id),
            'user_id'   => $payee_id
        ];

        $ordertimeline = new ProductOrderTimeline;
        $ordertimeline->user = $user_id;
        $ordertimeline->tid = $order->id;
        $ordertimeline->type = 'new_order_amount';
        $ordertimeline->data = $timeline;
        $ordertimeline->save();

        $this->remove_cart_stock();
        //Send email to customer



        dispatch(function() use ($spv, $order){
            if (!$payee = \App\User::find($order->payee_user_id)) {
                return false;
            }

            // Email class
            $email = new \App\Email;
            // Get email template
            $template = $email->template(block_path('shop', 'Email/purchased_product_email.php'), ['order' => $order, 'order_id' => $order->id]);
            // Email array
            $mail = [
                'to' => $spv->email,
                'subject' => __('Your purchased product(s)', ['website' => config('app.name')]),
                'body' => $template
            ];

            $email->send($mail);
        });

        return true;
    }


    // This is not working for now!

    private function remove_cart_stock(){
        $session_cart = \DarryCart::session($this->bio->id)->getContent();

        foreach ($session_cart as $item) {
            $quantity = $item->quantity;

            $product = Product::find(ao($item->attributes, 'product_id'));

            if ($product && ao($product->stock_settings, 'enable')) {

                if (!empty(ao($item, 'attributes.options')) && $option = ProductOption::find(ao($item, 'attributes.options.id'))) {
                    $option->decrement('stock', $option->stock - $quantity <= 0 ? $option->stock : $quantity);
                }else{
                    $product->decrement('stock', $product->stock - $quantity <= 0 ? $product->stock : $quantity);
                }
            }
        }

        return true;
    }
}