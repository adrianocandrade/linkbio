<?php

namespace App\Wallet;
use Illuminate\Http\File;
use App\Models\Wallet as Yetti_Wallet;

class Rave{
    public static function update_sub_account($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }

        if (!$wallet->rave_subaccount_setup) {
            return false;
        }

        $sub_account_id = ao($wallet->rave_subaccount, 'id');

        $body = [
            'account_bank'      => ao($wallet->settlement, 'bank_code'),
            'account_number'    => ao($wallet->settlement, 'account_number')
        ];

        $rave = \Rave::client('PUT', "https://api.flutterwave.com/v3/subaccounts/$sub_account_id", $body);
        if (ao($rave, 'status') !== 'success') {
            logActivity(user('email', $user_id), 'Rave Error', ao($rave, 'message'));
            return ['status' => false, 'response' => ao($rave, 'message')];
        }


        return ['status' => true, 'response' => ''];

    }

    public static function create_sub_account($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }

        $body = [
            'account_bank'      => ao($wallet->settlement, 'bank_code'),
            'account_number'    => ao($wallet->settlement, 'account_number'),
            'business_name'     => user('name', $user_id),
            'country'           => $wallet->default_country,
            'split_value'       => '0',
            'split_type'        => 'flat',
            'business_mobile'   => null,
            'business_email'    => user('email', $user_id),
            'meta' => [
                'user_id' => $user_id
            ]
        ];


        $rave = \Rave::client('POST', 'https://api.flutterwave.com/v3/subaccounts', $body);


        if (ao($rave, 'status') !== 'success') {
            logActivity(user('email', $user_id), 'Rave Error', ao($rave, 'message'));
            $wallet->wallet_setup = 0;
            $wallet->save();

            return ['status' => false, 'response' => ao($rave, 'message')];
        }


        $rave_subaccount = [
            'id' => ao($rave, 'data.id'),
            'subaccount_id' => ao($rave, 'data.subaccount_id')
        ];
        $wallet->rave_setup = 1;
        $wallet->rave_subaccount = $rave_subaccount;
        $wallet->update();

        return ['status' => true, 'response' => ''];
    }
    
    public static function get_all_banks(){
        $banks_file = getOtherResourceFile('flutterwave_countries', 'others', true);
        $banks = json_to_array($banks_file);


        return $banks;
    }

    public static function get_rave_config($country_code, $key = null){
        $country_code = strtoupper($country_code);
        $country_file = getOtherResourceFile('flutterwave_countries', 'others', true);
        $country = json_to_array($country_file);

        if (!array_key_exists($country_code, $country)) {
            return false;
        }

        $country = ao($country, $country_code);
        return ao($country, $key);
    }

    public static function get_payout_method_html($country){
        if (!$config = self::get_rave_config($country)) {
            return false;
        }


        return view('wallet::include.payout-methods', ['config' => $config, 'country' => $country]);
    }

    public static function client($request_type = 'POST', $uri, $body = []){
        $rave_secret = config('app.RAVE_SECRET_KEY');
        // Init Guzzel Client
        $client = new \GuzzleHttp\Client(['http_errors' => false]);
        $headers = [
            'Content-Type' => 'application/json',
            'cache-control' => 'no-cache',
            'Authorization' => "Bearer $rave_secret",
        ];

        $body = json_encode($body);
        $content = ['headers' => $headers, 'body' => $body, 'verify' => false];
        $response = $client->request($request_type, $uri, $content);


        $results = $response->getBody()->getContents();
        if (is_json($results)) {
            return json_decode($results, true);
        }

        return $results;
    }
}
