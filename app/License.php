<?php

namespace App;

use Illuminate\Support\ServiceProvider;

class License{

    // Simplified License Class - No External Calls

    public static function validate_envato($license_code){
        return ['code' => $license_code];
    }

    public static function validate_wj($license_code){
        return ['success' => true];
    }

    public static function validate_gumroad($license_code, $permalink = 'rio-script'){
        return ['purchase' => true];
    }

    public static function put_license($provider, $info = []){
        // No-op: Do not write license files
        return true;
    }

    public static function get($provider, $key = null){
        return null;
    }

    public static function get_array_license($provider){
        return [];
    }

    public static function get_provider_file_name($provider){
        return '';
    }

    public static function has_full_license(){
        return true;
    }

    public static function has_any_license(){
        return true;
    }

    public static function has_license_provider($provider){
        return true;
    }

    public static function plugin_key($plugin){
        return "{$plugin}_plugin.txt";
    }

    public static function put_plugin_license($plugin, $info = []){
        return true;
    }

    public static function remove_plugin_license($plugin){
        return true;
    }

    public static function get_plugin_license($plugin, $key = null){
        return ['purchase' => ['license_key' => 'valid']];
    }

    public static function has_plugin_license($plugin){
        return true;
    }

    public static function get_plugin_product_id($plugin){
        return '00000000';
    }

    public static function get_plugin_license_array($plugin){
        return [];
    }
}
