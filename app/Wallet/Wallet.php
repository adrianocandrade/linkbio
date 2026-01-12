<?php

namespace App\Wallet;
use Illuminate\Http\File;
use App\Models\Wallet as Yetti_Wallet;
use App\Models\WalletSavedCard;
use App\Models\WalletTransaction;

class Wallet{
    public function earnings($user_id, $nr = false){
        $earnings = 0;
        foreach (WalletTransaction::where('user', $user_id)->where('type', 'plus')->get() as $items) {
            $earnings = ($earnings + $items->amount);
        }

        $earnings = (float) $earnings;

        if ($nr) {
            return nr($earnings);
        }

        return number_format($earnings, 1);
    }

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

    public static function save_card($user_id, $payload){
        if (!$wallet = self::wallet_setup($user_id)) {
            return false;
        }
        if (empty(ao($payload, 'token'))) {
            return false;
        }

        $last_four = ao($payload, 'last_4digits');
        if (!$saved_card = WalletSavedCard::where('user', $user_id)->where('last_four', $last_four)->first()) {
            $card = new WalletSavedCard;
            $card->user = $user_id;
            $card->last_four = $last_four;
            $card->token = ao($payload, 'token');
            $card->payload = $payload;
            $card->save();


            return true;
        }


        $saved_card->last_four = $last_four;
        $saved_card->token = ao($payload, 'token');
        $saved_card->payload = $payload;
        $saved_card->update();

        return true;
    }


    public static function wallet_setup($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            $country_file = getOtherResourceFile('wallet_countries', 'others', true);
            $country = json_to_array($country_file);

            $countryIso = geoCountry(getIp(), 'country.iso_code');
            $countryIso = strtoupper($countryIso);
            
            if (!array_key_exists($countryIso, $country)) {
                $countryIso = 'US';
            }

            $wallet = new Yetti_Wallet;
            $wallet->user = $user_id;
            $wallet->default_country = $countryIso;
            $wallet->save();
            return false;
        }



        if (!$wallet->wallet_setup) {
            return false;
        }


        return $wallet;
    }

    public static function currency($user_id){
        return \Wallet::get('default_currency', $user_id);
    }

    public static function get($key = null, $user = false){
        $user_id = auth()->user()->id ?? null;
        if ($user) {
            $user_id = $user;
        }

        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }


        return ao($wallet->toArray(), $key);
    }

    public static function wallet_config($country_code, $key = null){
        $country_code = strtoupper($country_code);
        $country_file = getOtherResourceFile('wallet_countries', 'others', true);
        $country = json_to_array($country_file);

        if (!array_key_exists($country_code, $country)) {
            return false;
        }

        $country = ao($country, $country_code);
        return ao($country, $key);
    }

    public static function payment_option($user_id){
        $wallet_country = self::get('default_country', $user_id);


        return 'yetti_payment';
    }

    public static function balance($user_id, $only_balance = false){
        if ($only_balance) {
            return \Wallet::get('balance');
        }
        return price_with_cur(\Wallet::currency($user_id), \Wallet::get('balance'));
    }

    public static function pin($is_password = false){
        return view('wallet::include.pin', ['is_password' => $is_password]);
    }

    public static function create_pin($user_id, $request){
        if (!$wallet = self::wallet_setup($user_id)) {
            return false;
        }

        $request->validate([
            'pin.*'  => 'required'
        ]);

        $pin = implode('', $request->pin);

        $wallet->pin = \Hash::make($pin);
        $wallet->update();
        return true;
    }

    public static function payout_details($user_id){
        if (!$wallet = Yetti_Wallet::where('user', $user_id)->first()) {
            return false;
        }

        $config = \Wallet::wallet_config($wallet->default_country);



        return view('wallet::include.payout-details', ['wallet' => $wallet, 'config' => $config]);
    }

    public static function sxref(){
        $sxref = md5(microtime());


        return "yetti_$sxref";
    }
}
