<?php

namespace App\Listeners\User;

use App\Events\NewUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Email;
use App\Models\Wallet as Yetti_Wallet;

class NewUserWallet{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(){
        //
    }

    /**
     * Handle the event.
     *
     * @param  NewUser  $event
     * @return void
     */
    public function handle(NewUser $event){
        // Get user from event
        $user = $event->user;


        $country_file = getOtherResourceFile('wallet_countries', 'others', true);
        $country = json_to_array($country_file);

        $countryIso = geoCountry(getIp(), 'country.iso_code');
        $countryIso = strtoupper($countryIso);
        
        if (!array_key_exists($countryIso, $country)) {
            $countryIso = 'US';
        }

        $wallet = new Yetti_Wallet;
        $wallet->user = $user->id;
        $wallet->default_country = $countryIso;
        $wallet->save();
    }
}
