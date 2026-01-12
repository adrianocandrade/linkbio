<?php

namespace Sandy\Payments\square\controllers;
use Illuminate\Http\Request;
use App\Models\PaymentsSpv;
use App\Payments;
use Route;
use Square\Models\CreateOrderRequest;
use Square\Models\CreateCheckoutRequest;
use Square\Models\Order;
use Square\Models\OrderLineItem;
use Square\Models\Money;
use Square\Exceptions\ApiException;
use Square\SquareClient;

class SquareController{
    public function create(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');


        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }


        $access_token = ao($spv->keys, 'access_token');
        $location_id =  ao($spv->keys, 'location_id');
        $callback = (Route::has('sandy-payments-square-verify') ? route('sandy-payments-square-verify', ['sxref' => $sxref]) : url('/'));

        // Initialize the authorization for Square
        $client = new SquareClient([
          'accessToken' => $access_token,
          'environment' => ao($spv->keys, 'mode')
        ]);


        try {
          $checkout_api = $client->getCheckoutApi();

          // Monetary amounts are specified in the smallest unit of the applicable currency.
          // This amount is in cents. It's also hard-coded for $1.00, which isn't very useful.
          
          // Set currency to the currency for the location
          $currency = $client->getLocationsApi()->retrieveLocation($location_id)->getResult()->getLocation()->getCurrency();

          $money = new Money();
          $money->setCurrency($currency);
          $money->setAmount(($spv->price * 100));

          $item = new OrderLineItem(1);
          $item->setName(ao($spv->meta, 'title') ?? __('Purchasing an item on :website', ['website' => config('app.name')]));
          $item->setBasePriceMoney($money);


          // Create a new order and add the line items as necessary.
          $order = new Order($location_id);
          $order->setLineItems([$item]);

          $create_order_request = new CreateOrderRequest();
          $create_order_request->setOrder($order);

          // Similar to payments you must have a unique idempotency key.
          $checkout_request = new CreateCheckoutRequest(uniqid(), $create_order_request);
          // Set a custom redirect URL, otherwise a default Square confirmation page will be used
          $checkout_request->setRedirectUrl($callback);

          $response = $checkout_api->createCheckout($location_id, $checkout_request);

          // If there was an error with the request we will
          // print them to the browser screen here
          if ($response->isError()) {
            $errors = [];
            foreach ($response->getErrors() as $error) {
                $errors[] = $error->getDetail();
            }

            return fancy_error('Square', implode(', ', $errors));
          }



          
          return redirect($response->getResult()->getCheckout()->getCheckoutPageUrl());
        } catch (\ApiException $e) {
            return fancy_error('Square', $e->getResponseBody());
        }

        // Return empty response
        return fancy_error('Square', __('No response got'));
    }

    public function verify(Request $request){
        // Get sxref from url
        $sxref = $request->get('sxref');
        // GET SPV FROM DB
        if (!$spv = PaymentsSpv::where('sxref', $sxref)->first()) {
            abort(404);
        }

        // Get refrence from url
        $transaction_id = !empty($request->get('transactionId')) ? $request->get('transactionId') : '';
        $access_token = ao($spv->keys, 'access_token');
        $location_id =  ao($spv->keys, 'location_id');

        // Initialize the authorization for Square
        $client = new SquareClient([
          'accessToken' => $access_token,
          'environment' => ao($spv->keys, 'mode')
        ]);


        try {
          $orders_api = $client->getOrdersApi();
          $response = $orders_api->retrieveOrder($transaction_id);


          if ($response->isError()) {
            $errors = [];
            foreach ($response->getErrors() as $error) {
                $errors[] = $error->getDetail();
            }

            return fancy_error('Square', implode(', ', $errors));
          }

          $order = $response->getResult()->getOrder();

          if ($order->getState() != 'COMPLETED') {
              $tranx = $order->getId();
              Payments::failed($spv->id, $transaction_id, $tranx);

              return fancy_error('Square', __('Payment was not successful.'));
          }

          if ($order->getState() == 'COMPLETED'){
              $result = $order->getState();
              Payments::success($spv->id, $transaction_id, $result);
          }

          $callback = url_query($spv->callback, ['sxref' => $spv->sxref]);
          return redirect($callback);
        } catch (\ApiException $e) {
            return fancy_error('Square', $e->getResponseBody());
        }


        // Return empty response
        return fancy_error('Square', __('No response got'));

    }

}