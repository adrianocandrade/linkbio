<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Camroncade\Timezone\Facades\Timezone;
use Modules\Admin\Http\Controllers\Base\Controller;
use App\Models\Setting;

class SettingsController extends Controller{
    public function settings(){
        $socials = socials();
        $invoice = getOtherResourceFile('invoiceField');
        $timezone = Timezone::selectForm(settings('others.timezone'), '', ['name' => 'settings[others][timezone]', 'class' => 'bg-w']);

        return view('admin::settings.settings', ['socials' => $socials, 'invoiceField' => $invoice, 'timezone' => $timezone]);
    }

    public function updatehtaccess($type){
        if (!in_array($type, ['https', 'revert'])) {
            abort(404);
        }

        $htaccess = '.htaccess';
        $https = '';

        if ($type == 'https') {
            $https = '
                RewriteCond %{HTTPS} !=on
                RewriteRule .* https://%{HTTP_HOST}%{REQUEST_URI} [R,L]';
        }


        $scheme = '<IfModule mod_rewrite.c>
            <IfModule mod_negotiation.c>
                Options -MultiViews
            </IfModule>

            RewriteEngine On

            RewriteCond %{REQUEST_FILENAME} -d [OR]
            RewriteCond %{REQUEST_FILENAME} -f
            RewriteRule ^ ^$1 [N]

            RewriteCond %{REQUEST_URI} (\.\w+$) [NC]
            RewriteRule ^(.*)$ public/$1 

            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteRule ^ server.php
            '. $https .'
        </IfModule>';

        $update = fopen(base_path($htaccess), 'w');
        fwrite($update, $scheme);
        

        return redirect()->route('admin-settings')->with('success', __('Htaccess updated successfully'));
    }

    public function post(Request $request){

        // Loop & post settings

        if (!empty($request->settings)) {
            $settings = [];
            foreach ($request->settings as $key => $value) {
                
                $settings[$key] = $value;

                $value = $value;
                if (is_array($value)) {
                    $settings[$key] = json_encode($value);
                    $value = json_encode($value);
                }

                $key_value = ['key' => $key, 'value' => $value];

                if (Setting::where('key', $key)->first()) {
                    Setting::where('key', $key)->update(['value' => $value]);
                }else{
                    Setting::insert($key_value);
                }
            }
        }

        // Logo & Favicon
        $this->logo_favicon($request);

        // Loop & post env

        if (!empty($request->env)) {
            $env = [];
            foreach ($request->env as $key => $value) {
                $env[$key] = $value;
            }

            env_update($env);
        }

        env_update(['APP_URL' => route('index-home')]);
        $this->ios_splash($request);


        return back()->with('success', __('Saved Successfully'));
    }

    
    private function ios_splash($request){
        $putStorage = function($directory, $file, $name){
            $filesystem = 'local';

            $put = \Storage::disk($filesystem)->putFileAs($directory, $file, $name);
            \Storage::disk($filesystem)->setVisibility($put, 'public');

            $put = basename($put);
            return $put;
        };

        $settings = settings('pwa_splash') ?? [];
        if (!empty($ios_pwa_splash = $request->ios_pwa_splash)) {
            foreach ($ios_pwa_splash as $key => $value) {
                $pathinfo = pathinfo($value->getClientOriginalName());
                $size = explode('x', $key);
                $name = "splash-$key." . ao($pathinfo, 'extension');


                $validator = "image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=$size[0],height=$size[1]";
                $request->validate([
                    "ios_pwa_splash.$key" => "$validator",
                ]);

                if (!empty($previous_image = ao($settings, $key))) {
                    if(file_exists($path = public_path('media/bio/pwa-splash/'. $previous_image))){
                        unlink($path); 
                    }
                }

                $imageName = $putStorage('media/bio/pwa-splash', $value, $name);
                $settings[$key] = $imageName;
            }
        }


        settings_put('pwa_splash', $settings);
    }

    private function logo_favicon($request){
        if (!empty($request->mix_logo)) {
            $slug = md5(microtime());
            $request->validate([
                'mix_logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (!empty(settings('mix_logo'))) {
                if(mediaExists('media/site/logo', settings('mix_logo'))){
                    storageDelete('media/site/logo', settings('mix_logo')); 
                }
            }

            $imageName = putStorage('media/site/logo', $request->mix_logo);

            $values = array('value' => $imageName);
            Setting::where('key', 'mix_logo')->first() ? Setting::where('key', 'mix_logo')->update($values) : Setting::insert(['key' => 'mix_logo', 'value' => $imageName]);
        }

        if (!empty($request->logo)) {
            $slug = md5(microtime());
            $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (!empty(settings('logo'))) {
                if(mediaExists('media/site/logo', settings('logo'))){
                    storageDelete('media/site/logo', settings('logo')); 
                }
            }

            $imageName = putStorage('media/site/logo', $request->logo);

            $values = array('value' => $imageName);
            Setting::where('key', 'logo')->first() ? Setting::where('key', 'logo')->update($values) : Setting::insert(['key' => 'logo', 'value' => $imageName]);
        }

        if (!empty($request->favicon)) {
            $slug = md5(microtime());
            $request->validate([
                'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            if (!empty(settings('favicon'))) {
                if(mediaExists('media/site/favicon', settings('favicon'))){
                    storageDelete('media/site/favicon', settings('favicon')); 
                }
            }

            $imageName = putStorage('media/site/favicon', $request->favicon);


            $values = array('value' => $imageName);
            Setting::where('key', 'favicon')->first() ? Setting::where('key', 'favicon')->update($values) : Setting::insert(['key' => 'favicon', 'value' => $imageName]);
        }
    }
}
