<?php

namespace Sandy\Payments\paystack\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use App\Payments;
use Route;

class PaystackController{
    function __construct(){

    }

    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // Paystack secret key 
        $key = ao($spv->keys, 'secret');

        // Init Guzzel Client
        $client = new Client(['http_errors' => false]);

        // Paystack headers
        $headers = [
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache',
            'authorization' => "Bearer $key",
        ];

        // Callback url
        $callback = (Route::has('sandy-payments-paystack-verify') ? route('sandy-payments-paystack-verify', ['sxref' => $sxref]) : url('/'));


        // Paystack body
        $body = ['amount' => ($spv->price * 100), 'email' => $spv->email, 'callback_url' => $callback];
        $body = json_encode($body);

        // Send request to paystack
        try {
            $initialize = $client->request('POST', 'https://api.paystack.co/transaction/initialize', ['headers' => $headers, 'body' => $body, 'verify' => false]);

            // Redirect to paystack page
            return redirect(json_decode($initialize->getBody()->getContents())->data->authorization_url);

        } catch (\Exception $e) {

            // Return with errors
            return redirect()->route('index-home')->with('error', $e->getMessage());
        }

        // Return empty response
        return redirect()->route('index-home')->with('error', __('No response got'));
    }

    public function verify(Request $request){
        $client = new Client(['http_errors' => false]);
        // Get sxref from url
        $sxref = $request->get('sxref');

        // Get refrence from url
        $reference = !empty($request->get('reference')) ? $request->get('reference') : '';


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // Paystack secret key 
        $key = ao($spv->keys, 'secret');

        // Paystack headers
        $headers = [
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache',
            'authorization' => "Bearer $key",
        ];

        // Paystack verify
        try {
            $result = $client->request('GET', 'https://api.paystack.co/transaction/verify/' . rawurlencode($reference), ['headers' => $headers]);

            $tranx = json_decode($result->getBody()->getContents());
            if(!$tranx->status){
              return redirect('/')->with('error',  __('API returned error - :message', ['message' => $tranx->message]));
            }

            if($tranx->data->status == "success"){
                Payments::success($spv->id, $reference, $tranx);
            }

            $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);

            return redirect($callback);

        } catch (\Exception $e) {
            
        }
    }
}