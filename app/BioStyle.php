<?php

namespace App;
use Illuminate\Http\File;

class BioStyle{
    //public static $path = base_path('sandy/Themes'); 


    public static function get_bottom_bar($user_id){
        $store = \App\Shop\Shop::get(null, $user_id);

        if (!$store) {
            return false;
        }

        return view('bio::include.bottom-bar');
    }

    public static function getCss($user, $theme = null){
        if (!$theme_css = self::getThemeCss($theme)) {
            return false;
        }

        $hex2rgb = function($color){
            try {
                $array = hex2rgb($color);

                $rgb = is_array($array) ? implode(',', $array) : '#000000';

                return $rgb;
            } catch (\Exception $e) {
                
            }
        };

        preg_match_all("/{media: ([^}]+)}/", $theme_css, $arr);
        $replacers = [
            '{button_background}' => user('color.button_background', $user),
            '{button_text_color}' => user('color.button_color', $user),
            '{button_background_rgb}' => $hex2rgb(user('color.button_background', $user))
        ];

        foreach (ao($arr, 1) as $key => $value) {
            $replacers["{media: $value}"] = gs("assets/image/theme/$theme", $value);
        }

        $css = str_replace(array_keys($replacers), array_values($replacers), $theme_css);

        $replace = [
            "/\n([\S])/" => '$1',
            "/\r/" => '',
            "/\n/" => '',
            "/\t/" => '',
            "/ +/" => ' ',
            "/> +</" => '><',
        ];

        if (!config('app.LARAVEL_PAGE_SPEED_ENABLE')) {
            $css = preg_replace(array_keys($replace), array_values($replace), $css);
        }
        return $css;
    }

    public static function path(){
        $path = base_path('sandy/Bio/Themes');

        return $path;
    }

    public static function config($theme, $key = null){
        if (!self::has($theme)) {
            return false;
        }


        if (file_exists($file = self::getdir($theme, 'config.php'))) {
            $config = file_get_contents($file);
            $config = json_decode($config, true);

            if (!is_array($config)) {
                $config = [];
            }

            return ao($config, $key);
        }
    }

    public static function getdir($theme, $dir = ''){
        $path = self::path();
        $check = "$path/$theme";

        $dir = !empty($dir) ? "/$dir" : '';

        if (is_dir($check)) {
            return "$check/$dir";
        }

        return false;
    }

    public static function has($theme){
        $path = self::path();
        $dir = "$path/$theme";
        if (is_dir($dir)) {
            return true;
        }

        return false;
    }

    public static function makePublic($theme){
        $path = self::path();
        if (!self::has($theme)) {
            return false;
        }

        storageDeleteDir($dir = "assets/image/theme/$theme");

        if (!is_dir($path = "$path/$theme/media")) {
            return false;
        }

        $directory = new \DirectoryIterator($path);
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $file = $info->getPathname();
                $name = $info->getFilename();

                getStoragePutAs($dir, new File($file), $name);
            }
        }
        return true;
    }

    public static function getMediaNames($theme){
        $path = self::path();
        $media = [];

        if (!is_dir($path = "$path/$theme/media")) {
            return [];
        }

        $directory = new \DirectoryIterator($path);
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $media[] = $info->getFilename();
                $file = $info->getPathname();
            }
        }
        return $media;
    }


    public static function getCssName($theme){
        $path = self::path();
        $css = [];

        if (!is_dir($path = "$path/$theme/css")) {
            return [];
        }

        $directory = new \DirectoryIterator($path);
        foreach ($directory as $info){
            if (!$info->isDot()) {
                // Important info
                $css[] = $info->getFilename();
                $file = $info->getPathname();
            }
        }
        return $css;
    }

    public static function getAll(){
        $configs = [];
        $dir = self::path();

        foreach(scandir($path = $dir) as $dir){
            if (file_exists($filepath = "{$path}/{$dir}/config.php")) {
                $config = file_get_contents($filepath);
                $configs[$dir] = json_decode($config, true);
            }
        }


        return $configs;
    }

    public static function getThemeCss($theme = null){
        $path = base_path('sandy/Bio/Themes');

        if (is_dir($path = "$path/$theme/css")) {

            $css = '';
            $directory = new \DirectoryIterator($path);
            foreach ($directory as $info){
                if (!$info->isDot()) {
                    // Important info
                    $cssFile = $info->getFilename();
                    $file = $info->getPathname();


                    // Css Files
                    $get = file_get_contents($file);

                    $css .= $get;
                }
            }


            return $css;
        }

        return false;
    }
}
