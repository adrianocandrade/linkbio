<?php

namespace App;
use Illuminate\Http\File;
use Mews\Captcha\Facades\Captcha as MewsCaptcha;

class Captcha{
    public static function html(){
        $html = '';
        // Get Captcha types
        $type = self::type();

        // Check if is enabled
        if (!self::enabled()) {
            return false;
        }

        switch ($type) {
            case 'default':
                $html = '<div class="grid grid-cols-2 gap-4"><div class="flex justify-center">'. captcha_img('sandy') .'</div> <div class="form-input"><label>'. __('Captcha') .'</label> <input autocomplete="off" type="text" name="captcha"> </div></div>';
            break;

            case 'google_recaptcha':
                $html = htmlFormSnippet();
            break;
        }


        return $html;

    }

    public static function head(){
        return \ReCaptcha::htmlScriptTagJsApi();
    }

    public static function type(){
        return settings('captcha.type');
    }

    public static function enabled(){
        return settings('captcha.enable');
    }

    public static function validator($request){
        $validator = false;

        // Get Captcha types
        $type = self::type();

        // Check if is enabled
        if (!self::enabled()) {
            return false;
        }


        switch ($type) {
            case 'default':
                $validator = $request->validate(['captcha' => 'required|captcha']);
            break;
            case 'google_recaptcha':
                $validator = $request->validate(['g-recaptcha-response' => 'recaptcha']);
            break;
        }


        return $validator;
    }
}
