<?php

namespace Sandy\Payments\paytm\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use Anand\LaravelPaytmWallet\Facades\PaytmWallet;
use App\Payments;
use Route;

class PayTMController{
    public function credentials($keys){
        $credentials = [
            'env' => ao($keys, 'environment'),
            'merchant_id' => ao($keys, 'merchant_id'),
            'merchant_key' => ao($keys, 'merchant_key'),
            'merchant_website' => ao($keys, 'merchant_website'),
            'channel' => ao($keys, 'channel'),
            'industry_type' => ao($keys, 'industry_type')
        ];

        config(['services.paytm-wallet' => $credentials]);
    }

    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'paytm')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        // Credentials
        $this->credentials($spv->keys);

        // Phone number
        if (empty($phone = $request->get('phone'))) {
            return view('Payment-paytm::paytm-init', ['sxref' => $sxref]);
        }
        // Verification uri
        $return_uri = route('sandy-payments-paytm-verify', ['sxref' => $sxref]);

        // Paytm start transaction
        try {
            $transaction = PaytmWallet::with('receive');
            $transaction->prepare([
               'order'         => \Str::random(10),
               'email'         => $spv->email,
               'amount'        => $spv->price,
               'user'          => \Str::random(10),
               'mobile_number' => $phone,
               'callback_url'  => $return_uri
            ]);

            return $transaction->receive();
        } catch (\Exception $e) {
            return fancy_error(__('PayTm Error!'), $e->getMessage());
        }
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->where('method', 'paytm')->first()) {
            return fancy_error(__('Please try again.'), __('Payment not found or expired.'));
        }

        // Credentials
        $this->credentials($spv->keys);

        try {
            // Get Transaction from PayTm
            $transaction = PaytmWallet::with('receive');
            // Get Response from transaction
            $response = $transaction->response();
            // Get Order ID
            $order_id = $transaction->getOrderId();
            if ($transaction->isSuccessful()) {
                Payments::success($spv->id, $order_id, $response);

                // Callback
                $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
                return redirect($callback);

            }else if($transaction->isFailed()){
                Payments::failed($spv->id, $order_id, $response);

                return fancy_error(__('PayTm Error!'), __('Payment was not successful or canceled.'));
            }
        } catch (\Exception $e) {
            return fancy_error(__('PayTm Error!'), $e->getMessage());
        }


        //
        return fancy_error(__('PayTm Error!'), __('Transaction is either open or invalid.'));
    }
}