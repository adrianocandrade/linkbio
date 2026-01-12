<?php

namespace Sandy\Payments\razor\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use Stripe\Stripe;
use Razorpay\Api\Api as Razor;
use App\Payments;
use Route;

class RazorController{
    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'razor')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        $client = ao($spv->keys, 'client');
        $secret = ao($spv->keys, 'secret');

        // Init Price

        $price = ($spv->price * 100);

        // Order
        $order = [
            'receipt'         => rand(),
            'amount'          => $price,
            'currency'        => strtoupper($spv->currency),
            'payment_capture' => 1
        ];

        try {
            $api = new Razor($client, $secret);
            $razorOrder = $api->order->create($order);
        } catch (\Exception $e) {
            return fancy_error(__('RazorPay Error!'), $e->getMessage());
        }

        // Data to be sent to view
        /* extra
            "prefill"           => [
                "name"              => $user->name,
                "email"             => $user->email,
            ],
            "theme"             => [
                "color"             => "#000"
            ],
        */
        $data = [
            "key"               => $client,
            "amount"            => $price,
            "name"              => ao($spv->meta, 'name'),
            "description"       => __("Purchasing an item of :price on :website", ['price' => nf($spv->price), 'website' => config('app.name')]),
            "image"             => favicon('light'),
            "order_id"          => $razorOrder['id'],
            "theme"             => [],
            "prefill"           => [
                "email"         => $spv->email,
            ],
        ];
        $data = json_encode($data);

        // View
        return view('Payment-razor::razor-init', ['data' => $data, 'sxref' => $sxref]);
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'razor')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }


        // Api Keys
        $client = ao($spv->keys, 'client');
        $secret = ao($spv->keys, 'secret');

        // Check for payment ID
        if(empty($request->get('razorpay_payment_id'))) {
            return fancy_error(__('Please try again.'), __('Payment ID not set.'));
        }

        try {
            $api = new Razor($client, $secret);
            $payment = $api->payment->fetch($request->get('razorpay_payment_id'));


            $json = [];
            foreach ($payment as $key => $value){
                $json[$key] = $value;
            }


            if (!$payment->captured) {
                Payments::failed($spv->id, $payment->id, $json);

                return fancy_error(__('RazorPay Error!'), __('Payment not successful or canceled.'));
            }

            Payments::success($spv->id, $payment->id, $json);

            // Callback
            $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
            return redirect($callback);

        } catch (\Exception $e) {
            return fancy_error(__('RazorPay Error!'), $e->getMessage());
        }

        return fancy_error(__('RazorPay Error!'), __('Payment not successful or canceled.'));
    }
}