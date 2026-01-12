<?php

namespace App\Traits;
use Illuminate\Http\Request;
use App\Traits\UserBioInfo;
use App\Models\StoreSetting;
use Illuminate\Support\Facades\View;
use App\Models\YettiSpv;
use App\Models\YettiSpvHistory;
use App\User;
use App\Models\WalletTransaction;

trait YettiPayment {
    public function payment_charges_subaccount($user_id, $price){
        $config = \Wallet::wallet_config(\Wallet::get('default_country', $user_id));

        $extra = ao($config, 'charges.extra');

        $percent = ao($config, 'charges.percent');
        $percent = ($percent / 100);
        $actual_percent = ($percent * $price);
        $actual_percent = ($actual_percent + $extra);

        if ($actual_percent > $price) {
            return $price;
        }

        $price = ($price - $actual_percent);

        return $price;
    }

    public function WalletTransaction($spv, $data){
        $users = [1 => ['user' => $spv->user, 'type' => 'plus'], 2 => ['user' => $spv->payee_user_id, 'type' => 'minus']];

        $transaction_data = [
            'bio' => $spv->user,
            'payee' => $spv->payee_user_id,
            'item' => ao($spv->meta, 'item'),
            'location' => tracking_log(),
            'payer_currency' => [
                'rate' => ao($spv->meta, 'payer.rate'),
                'price' => ao($spv->meta, 'payer.price'),
                'currency' => ao($spv->meta, 'payer.currency')
            ]
        ];

        foreach ($users as $key => $value) {
            $transaction = new WalletTransaction;
            $transaction->user = ao($value, 'user');
            $transaction->amount = $spv->price;
            $transaction->currency = $spv->currency;
            $transaction->spv_id = $spv->id;
            $transaction->type = ao($value, 'type');
            $transaction->transaction = $transaction_data;
            $transaction->payload = $data;
            $transaction->save();
        }


        return true;
    }

    public function payment_success($spvid, $reference, $data){
        if (!$spv = YettiSpv::where('id', $spvid)->first()) {
            return false;
        }
        $spv->is_paid = 1;
        $spv->method_ref = $reference;

        $spv->update();


        // Add To Transaction
        $this->WalletTransaction($spv, $data);


        dispatch(function() use($spv){
            if (!$user = \App\User::find($spv->user)) {
                return false;
            }
            // Email class
            $email = new \App\Email;
            // Get email template
            $template = $email->template('wallet/received_money', ['spv' => $spv]);
            // Email array
            $mail = [
                'to' => $user->email,
                'subject' => __('You made a sale!', ['website' => config('app.name')]),
                'body' => $template
            ];
            // Send Email
            $email->send($mail);
        });


        //
        if ($history = YettiSpvHistory::where('spv_id', $spv->id)->first()){
            $history->status = 1;
            $history->method = $spv->method;
            $history->method_ref = $reference;
            $history->payload_data = $data;
            $history->update();
        }else{
            $new = new YettiSpvHistory;
            $new->spv_id = $spv->id;
            $new->status = 1;
            $new->method = $spv->method;
            $new->method_ref = $reference;
            $new->payload_data = $data;

            $new->save();
        }

        return true;
    }
    public function rave_or_paypal(){

    }

    public static function payment_is_paid($sxref){
        if (!$payment = YettiSpv::where('sxref', $sxref)->first()) {
            return false;
        }

        if ($payment->is_paid) {
            return $payment;
        }
    }

    public function create_payment($user, $sxref, $data = [], $meta = []){
        $price = (float) ao($data, 'price');

        if (!$user = User::find($user)) {
            return false;
        }

        if (!$this->check_if_wallet_setup($user->id)) {
            return back()->with('bio_error', ['error' => 'Unable to Pay', 'response' => __('This user is unable to receive payments.')]);
        }

        if (!\Auth::check()) {
            return back()->with('error', __('Please login to proceed.'));
        }

        $current_user_id = auth()->user()->id;

        /*
        $currency_convert = \Bio::currency_conversion(\Wallet::get('default_currency', $user->id), $price);
        if (ao($currency_convert, 'status') !== 'success') {
            return back()->with('error', __('Could not convert currency, please try again.'));
        }
        $meta['payer']['rate'] = ao($currency_convert, 'data.rate');
        $meta['payer']['price'] = ao($currency_convert, 'data.to.amount');
        $meta['payer']['currency'] = ao($currency_convert, 'data.to.currency');
        */
    
        $payee = \Auth::user();

        $method = ao($data, 'method');

        $redirect = \Route::has("sandy-payments-$method-create") ? route("sandy-payments-$method-create", ['sxref' => $sxref]) : false;


        $split_amount = $this->payment_charges_subaccount($user->id, $price);
        $spv = new YettiSpv;
        $spv->email = $payee->email;
        $spv->user = $user->id;
        $spv->payee_user_id = $current_user_id;
        $spv->price = $price;
        $spv->split_price = $split_amount;
        $spv->currency = ao($data, 'currency');
        $spv->method = ao($data, 'method');
        $spv->callback = ao($data, 'callback');
        $spv->sxref = $sxref;
        $spv->meta = $meta;

        if ($price == 0) {
            $redirect = url_query(ao($data, 'callback'), ['sxref' => $sxref]);
            $spv->is_paid = 1;
        }
        $spv->save();

        if ($price == 0) {
            $this->WalletTransaction($spv, $data);
        }

        if ($redirect) {
            return redirect($redirect);
        }

        return back()->with('error', __('Payment route doesnt exists'));
    }

    public function check_if_wallet_setup($user_id){
        return \Wallet::wallet_setup($user_id);
    }
}