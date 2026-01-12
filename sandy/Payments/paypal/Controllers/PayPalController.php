<?php

namespace Sandy\Payments\paypal\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use App\Payments;
use Route;

class PayPalController{
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
        $clientkey = ao($spv->keys, 'client');
        $secretkey = ao($spv->keys, 'secret');
        $mode = ao($spv->mode, 'mode');

        $price = in_array($spv->currency, ['JPY', 'TWD', 'HUF']) ? number_format($spv->price, 0, '.', '') : number_format($spv->price, 2, '.', '');

        $paypal_settings = [
            'mode' => ao($spv->keys, 'mode'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR - User'
        ];


        // Api Content
        $apiContext = new ApiContext(new OAuthTokenCredential(
            ao($spv->keys, 'client'),
            ao($spv->keys, 'secret'))
        );
        $apiContext->setConfig($paypal_settings);

        // Paypal payer method
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        // Paypal item
        $item = new Item();
        $item->setName(ao($spv->meta, 'title'))->setCurrency($spv->currency)->setQuantity(1)->setPrice($price);


        // Item list
        $itemList = new ItemList();
        $itemList->setItems(array($item));

        // Set amount price
        $amount = new Amount();
        $amount->setCurrency($spv->currency)->setTotal($price);

        // Create transaction
        $transaction = new Transaction();
        $transaction->setAmount($amount)->setItemList($itemList)
        ->setDescription(ao($spv->meta, 'title'));


        // Verification uri
        $return_uri = route('sandy-payments-paypal-verify', ['sxref' => $sxref]);

        // Create redirect uri
        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl($return_uri)->setCancelUrl(url('/'));

        // Create payments
        $payment = new Payment();
        $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)
        ->setTransactions(array($transaction));


        try {
            $payment->create($apiContext);
        } catch (\Exception $e) {
            $error = json_decode($e->getData())->error_description ?? $e->getMessage();
            return fancy_error(__('From Paypal'), __('Paypal response - :error', ['error' =>  $error]));
        }

        // Check for approved url
        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        // Redirect with url
        if(isset($redirect_url)) {
            return redirect($redirect_url);
        }

        // Return with error
            return fancy_error(__('From Paypal.'), __('Paypal did not return payment url. Kindly try again.'));
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');

        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // Paypal settings
        $paypal_settings = [
            'mode' => ao($spv->keys, 'mode'),
            'http.ConnectionTimeOut' => 30,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'ERROR - User'
        ];

        // Api Content
        $apiContext = new ApiContext(new OAuthTokenCredential(
            ao($spv->keys, 'client'),
            ao($spv->keys, 'secret'))
        );
        $apiContext->setConfig($paypal_settings);

        if (empty($request->query('paymentId')) || empty($request->query('PayerID')) || empty($request->query('token'))){
            return fancy_error(__('From Paypal.'), __('Payment was not successful.'));
        }

        $payment = Payment::get($request->query('paymentId'), $apiContext);
        $execution = new PaymentExecution();
        $execution->setPayerId($request->query('PayerID'));

        $result = $payment->execute($execution, $apiContext);

        $reference = $request->query('paymentId');

        if ($result->getState() != 'approved') {
            $tranx = $result->getFailureReason();
            Payments::failed($spv->id, $reference, $tranx);

            return fancy_error(__('From Paypal.'), __('Payment was not successful.'));
        }

        if ($result->getState() == 'approved'){
            $result = $result->getState();
            Payments::success($spv->id, $reference, $result);
        }

        $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
        return redirect($callback);
    }
}