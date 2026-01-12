<?php

namespace App;
use Illuminate\Http\File;

class Bio{
    public static function emoji($emoji, $extension = 'gif'){
        $path = "assets/image/animated-emoji/$emoji.$extension";

        return gs($path);

    }
    public static function sxref($prefix = false){


        if ($prefix) {
            return $prefix . '_' . uniqid(time());
        }
        return 'wj_' . uniqid(time());
    }

    public static function is_auth($bio_id){
        if (!$user = \Auth::user()) {
            return false;
        }

        if ($user->id == $bio_id) {
            return true;
        }

        return false;
    }

    public static function dark_mode($bio_id){
        if (!$bio = \App\User::find($bio_id)) {
            return false;
        }
        $class = '';


        $session_dark = session()->get("bio-dark-$bio->id");

        if ($session_dark) {
            $class = 'is-dark';
        }
        if (user('settings.always_dark', $bio->id)) {
            $class = 'is-dark';
        }


        return $class;
    }

    public static function header_functions($bio){
        $html = '';


        $html .='<style id="bio-css-styles">'. BioStyle::getCss($bio->id, $bio->theme) .'</style>';

        $html .= getUserPixel($bio->id);
        $html .= BioColorCss($bio->id);
        $html .= userFont($bio->id);
        $html .= clean(\App\User::getAddToHead($bio->id));


        return $html;
    }
    public static function button_with_auth($user_id, $config = []){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        $class = ao($config, 'class');
        $text = ao($config, 'text');
        $link = ao($config, 'link');
        $attr = ao($config, 'attr');
        $tiny_avatar = null;

        if (!\Auth::check()) {
            $attr .= ' type="button"';
            $class .= ' login-modal-open';
            $link = '#'; 
        }

        if (\Auth::check()) {
            $tiny_avatar = "<div class=\"tiny-avatar\"><img src=\"". avatar() ."\" alt=\"\"></div>";
        }

        $button_tag = 'a';

        if (ao($config, 'is-button')) {
            $button_tag = 'button';
        }

        $html = "<$button_tag class=\"$class\" ".$attr." href=\"$link\"> <span>". __($text) ."</span> $tiny_avatar</$button_tag>";

        return $html;
    }

    public static function currency_conversion($base_currency, $price){
        $countryIso = geoCountry(getIp(), 'country.iso_code');
        $country_currency = (new \Currency)->country_currency($countryIso);


        try {
            $api = \Rave::client('GET', "https://api.flutterwave.com/v3/rates?from=$base_currency&to=$country_currency&amount=$price");
        } catch (\Exception $e) {
            return $e->getMessage();
        }

        return $api;

        $data = [
            'iso' => $countryIso,
            'query' => ao($api, 'query'),
            'info' => ao($api, 'info'),
            'result' => ao($api, 'result'),
        ];

        return $data;
    }


    public static function price($price, $user_id = false){
        if (!$bio = \App\User::find($user_id)) {
            return false;
        }
        
        
        if ($price == 0) {

            return __('Free');
        }


        if ($user_id) {
            $price = price_with_cur(ao($bio->payments, 'currency'), $price);
        }

        return $price;
    }

    public static function route($user_id, $route, $extra = []){

        $extra['bio'] = user('username', $user_id);
        $prefix = 'user-bio-';
        if (\Str::contains($route, $prefix)) {
            $route = str_replace($prefix, '', $route);
        }

        return route($prefix.$route, $extra);
    }


    public static function bio_banner($bio_id, $what = ''){
        if (!$bio = \App\User::find($bio_id)) {
            return false;
        }
        $theme = $bio->theme;

        if (!user('settings.banner_or_background', $bio->id)) {
            return false;
        }


        return view('bio::include.banner', ['bio' => $bio]);
    }


    public static function push_notification_script($user_id){
        if (!$bio = \App\User::find($user_id)) {
            return false;
        }


        // Check if is in plan
        if (!plan('settings.pwa_messaging', $bio->id)) {
            return false;
        }

        // Check if user is enabled
        if (!user('pwa.enable_push', $bio->id)) {
            return false;
        }


        return view('bio::vendor.push.script', ['bio' => $bio]);
    }

    public static function can_install_pwa($user_id){
        if (!$bio = \App\User::find($user_id)) {
            return false;
        }


        // Check if is enabled in admin

        // Check if is in plan
        if (!plan('settings.pwa', $bio->id)) {
            return false;
        }

        // Check if user is enabled
        if (!user('pwa.enable', $bio->id)) {
            return false;
        }

        return true;
    }

    public static function body_classes($bio_id){
        if (!$bio = \App\User::find($bio_id)) {
            return false;
        }


        $html = [];
        $html[] = \Bio::dark_mode($bio->id);
        $html[] =  radius_and_align_class($bio->id, 'radius');
        $html[] = !$bio->background ? '' : 'has-background';
        $html[] = user('settings.banner_or_background', $bio->id) ? 'is-bio-banner' : '';


        return implode(' ', $html);
    }
}
