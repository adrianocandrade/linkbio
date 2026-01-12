<?php

namespace Sandy\Payments\flutterwave\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use App\Payments;
use Route;
use App\Flutterwave\Flutterwave;

class FlutterwaveController{
    function __construct(){

    }

    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // flutterwave secret key 
        $key = ao($spv->keys, 'secret');
        $callback = (Route::has('sandy-payments-flutterwave-verify') ? route('sandy-payments-flutterwave-verify', ['sxref' => $sxref]) : url('/'));

        $flutterwave = new Flutterwave($key);

        //This generates a payment reference
        $reference = $flutterwave->generateReference();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => $spv->price,
            'email' => $spv->email,
            'tx_ref' => $reference,
            'currency' => $spv->currency,
            'redirect_url' => $callback,

            'customer' => [
                'email' => $spv->email,
            ],
        ];


        try {
            $payment = $flutterwave->initializePayment($data);
        } catch (\Exception $e) {
            return fancy_error('Flutterwave', $e->getMessage());
        }

        if (ao($payment, 'status') !== 'success') {
            return fancy_error('Flutterwave', ao($payment, 'message'));
        }


        return redirect(ao($payment, 'data.link'));
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // Get refrence from url
        $reference = !empty($request->get('reference')) ? $request->get('reference') : '';


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // flutterwave secret key 
        $key = ao($spv->keys, 'secret');
        $flutterwave = new Flutterwave($key);
        try {
            $transactionID = $flutterwave->getTransactionIDFromCallback();
            $data = $flutterwave->verifyTransaction($transactionID);
        } catch (\Exception $e) {
            return fancy_error('Flutterwave', $e->getMessage());
        }



        if (ao($data, 'data.status') == 'successful') {
            Payments::success($spv->id, $reference, $transactionID);
            $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
            return redirect($callback);
        }


        return fancy_error('Flutterwave', __('Could not complete your last payment.'));
    }
}