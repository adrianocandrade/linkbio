<?php

namespace Modules\Bio\Http\Traits;
use App\BioStyle;
use Carbon\Carbon;
use App\Traits\UserBioInfo;
use App\Models\CoursesOrder;
use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

trait BioTraits {
    


    public function lol(){
        return "LOVE";
    }
    public function bio_body_bg(){
        if(isset($this->mixing_auth) && $this->mixing_auth){
            return;
        }
        return getBioBackground($this->bio->id);
    }
    public function session_dark_mode(){
        $bio = $this->bio;
        $class = '';
        if(isset($this->mixing_auth) && $this->mixing_auth){
            return;
        }


        $session_dark = session()->get("bio-dark-$bio->id");

        if ($session_dark) {
            $class = 'is-dark';
        }
        if (user('settings.always_dark', $bio->id)) {
            $class = 'is-dark';
        }


        return $class;
    }
    
    public function body_classes(){

        $html = [];
        $html[] = $this->session_dark_mode();
        $html[] =  radius_and_align_class($this->bio->id, 'radius');
        $html[] = !$this->bio->background ? '' : 'has-background';
        $html[] = user('settings.banner_or_background', $this->bio->id) ? 'is-bio-banner' : '';


        return implode(' ', $html);
    }

    public function header_functions(){
        $html = '';

        if(isset($this->mixing_auth) && $this->mixing_auth){
            return;
        }

        $html .='<style id="bio-css-styles">'. BioStyle::getCss($this->bio->id, $this->bio->theme) .'</style>';

        $html .= getUserPixel($this->bio->id);
        $html .= BioColorCss($this->bio->id);
        $html .= userFont($this->bio->id);
        $html .= clean(\App\User::getAddToHead($this->bio->id));


        return $html;
    }

    public function is_auth(){
        if (!$user = \Auth::user()) {
            return false;
        }

        if ($user->id !== $this->bio->id) {
            return false;
        }

        return true;
    }

    public function price($price = 0){

        if ($price == 0) {

            return __('Free');
        }

        $price = price_with_cur(ao($this->bio->payments, 'currency'), $price);
        return $price;
    }

    public function route($route, $extra = []){
        $extra['bio'] = $this->bio->username;
        $prefix = 'user-bio-';
        if (\Str::contains($route, $prefix)) {
            $route = str_replace($prefix, '', $route);
        }

        return route($prefix . $route, $extra);
    }
}