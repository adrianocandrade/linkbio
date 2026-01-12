<?php

namespace Sandy\Payments\stripe\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use Stripe\Stripe;
use App\Payments;
use Route;

class StripeController{
    function __construct(){

    }

    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        // Init price

        try {

            $objects = $this->objects($spv);
            // Add secret key
            Stripe::setApiKey(ao($spv->keys, 'secret'));

            if ($error = ao($objects, 'error')) {
                return fancy_error(__('Stripe Error'), $error);
            }
            // Stripe
            $stripe = \Stripe\Checkout\Session::create(ao($objects, 'response'));

            // Redirect url
            $redirect = $stripe->url;

            // Add checkout id to db
            $spv_keys = $spv->keys;
            $spv_keys['checkout_id'] = $stripe->id;
            $spv_keys['payment_intent'] = $stripe->payment_intent;
            $spv->keys = $spv_keys;
            $spv->save();
        } catch (\Exception $e) {
            return fancy_error(__('Stripe Error'), $e->getMessage());
        }

        // Redirect to payment
        if (isset($redirect)) {
            return redirect($redirect);
        }
    }


    private function objects($spv){
        $error = false;
        $price = in_array($spv->currency, ['MGA', 'BIF', 'CLP', 'PYG', 'DJF', 'RWF', 'GNF', 'UGX', 'JPY', 'VND', 'VUV', 'XAF', 'KMF', 'KRW', 'XOF', 'XPF']) ? number_format($spv->price, 2, '.', '') : number_format($spv->price, 2, '.', '') * 100;

        $item = ao($spv->meta, 'payment_info');

        // Description
        $description = ao($item, 'description');
        if (!empty(ao($item, 'description'))) {
            $description = __("Purchasing an item of :price on :website", ['price' => nf($spv->price), 'website' => config('app.name')]);
        }

        // Callback url
        $callback = route('sandy-payments-stripe-verify', ['sxref' => $spv->sxref]);
        $cancel_url = !empty(url()->previous()) ? url()->previous() : url('/');

        $objects = ['payment_method_types' => ['card'], 'metadata' => ['spv_id' => $spv->id], 'success_url' => $callback,'cancel_url' => $cancel_url];


        if (ao($spv->meta, 'payment_mode.type') == 'recurring') {
            $recurring = $this->recurring($spv, $price);
            if (ao($recurring, 'error')) {
                $error = ao($recurring, 'error');
            }


            $objects['subscription_data'] = ao($recurring, 'response');
        }else{
            $objects['line_items'] = [[
                'name'        => ao($spv->meta, 'title') ?? ' ',
                'description' => $description,
                'amount'      => $price,
                'currency'    => $spv->currency,
                'quantity'    => 1,
            ]];
        }

        return ['error' => $error, 'response' => $objects];
    }

    private function recurring($spv, $price){
        Stripe::setApiKey(ao($spv->keys, 'secret'));
        $error = false;

        $item = ao($spv->meta, 'payment_mode');
        $id = ao($item, 'id');


        try {
            $stripe_product = \Stripe\Product::retrieve($id);
        } catch (\Exception $exception) {
            /* The product probably does not exist */
        }

        if(!isset($stripe_product)) {
            $stripe_product = \Stripe\Product::create([
                'id'    => $id,
                'name'  => ao($item, 'title'),
            ]);
        }

        $stripe_plan_id = $id;

        /* Check if we already have a payment plan created and try to get it */
        try {
            $stripe_plan = \Stripe\Plan::retrieve($stripe_plan_id);
        } catch (\Exception $exception) {
            /* The plan probably does not exist */
        }

        /* Create the plan if it doesnt exist already */
        if(!isset($stripe_plan)) {
            try {
                $stripe_plan = \Stripe\Plan::create([
                    'amount' => $price,
                    'interval' => ao($item, 'interval'),
                    'product' => $stripe_product->id,
                    'currency' => $spv->currency,
                    'id' => $stripe_plan_id
                ]);
            } catch (\Exception $e) {
                $error = $e->getMessage();
            }
        }

        $response = ['items' => [['plan' => $stripe_plan->id]]];
        return ['error' => $error, 'response' => $response];
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }
        // Get refrence from url
        $reference = ao($spv->keys, 'payment_intent');

        // Get stripe payment
        try {
            Stripe::setApiKey(ao($spv->keys, 'secret'));

            $stripe = \Stripe\PaymentIntent::retrieve($reference);


            if ($stripe->status !== 'succeeded') {
                $error = 'Payment status is unpaid.';

                if (!empty($error)) {
                    $error = 'Payment status is unpaid.';
                }

                //Payments::failed($spv->id, $reference, $stripe);

                return fancy_error(__('Stripe Error!'), $error);
            }


            if ($stripe->status == 'succeeded') {
                Payments::success($spv->id, $reference, $stripe);

                // Callback
                $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
                return redirect($callback);
            }
        } catch (\Exception $e) {
            return fancy_error(__('Stripe Error!'), $e->getMessage());
        }
    }
}