<?php

namespace App\Wallet;
use Illuminate\Http\File;
use App\Models\Wallet as Yetti_Wallet;
use App\Sandy\Kuda\KudaOpenApi;

class Kuda{

    public static function create_kuda_account($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }

        $tracking = "yetti_" . \Str::random(10);
        $payload = [
            'email'         =>  user('email', $user_id),
            'phoneNumber'   =>  user('phone_number', $user_id),
            'lastName'      =>  ao($wallet->settlement, 'last_name'),
            'firstName'     =>  ao($wallet->settlement, 'first_name'),
            'trackingReference' => $tracking
        ];


        $api = new KudaOpenApi(storage_path('kuda/private.pem'), storage_path('kuda/public.pem'), config('app.KUDA_CLIENT'));

        try {
            $api = $api->makeRequest('ADMIN_CREATE_VIRTUAL_ACCOUNT', $payload);
            if (ao($api, 'Status')) {
                $wallet->kuda_wallet_setup = 1;
                $wallet->kuda_wallet_id = $tracking;
                $wallet->update();
            }

        } catch (\Exception $th) {

        }

    }

    public static function fetch_kuda_account($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }
        $payload = [
            'trackingReference' => $wallet->kuda_wallet_id
        ];

        // this will return the account information
        try {
            $api = new KudaOpenApi(storage_path('kuda/private.pem'), storage_path('kuda/public.pem'), config('app.KUDA_CLIENT'));
            $api = $api->makeRequest('ADMIN_RETRIEVE_SINGLE_VIRTUAL_ACCOUNT', $payload);
            if (ao($api, 'Status')) {
                $wallet->kuda_wallet = ao($api, 'Data');
                $wallet->update();
            }
        } catch (\Exception $e) {
            
        }

    }


    public static function fetch_kuda_balance($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }
        $payload = [
            'trackingReference' => $wallet->kuda_wallet_id
        ];

        // this will return the account information
        try {
            $api = new KudaOpenApi(storage_path('kuda/private.pem'), storage_path('kuda/public.pem'), config('app.KUDA_CLIENT'));
            $api = $api->makeRequest('RETRIEVE_VIRTUAL_ACCOUNT_BALANCE', $payload);
            if (ao($api, 'Status')) {
                $wallet->balance = ao($api, 'Data.AvailableBalance');
                $wallet->update();
            }
        } catch (\Exception $e) {
            
        }
    }
}