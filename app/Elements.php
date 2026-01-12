<?php

namespace App;

use Illuminate\Support\ServiceProvider;
use Illuminate\Http\File;
use Carbon\Carbon;

class Elements{
    private $path;
    private $dir;

    function __construct(){
        $plugins = base_path('sandy/Segment');
        $this->dir = $plugins;
        $this->path = scandir($plugins);
    }

    public static function moveMedia($element){
        if (!self::has($element)) {
            return false;
        }

        $config = function($key = null) use ($element){
            return \Elements::config($element, $key);
        };

        if (mediaExists("assets/elements/$element")) {
            storageDelete("assets/elements/$element");
        }

        $filesystem = env('FILESYSTEM');
        \Storage::makeDirectory("assets/elements/$element", 0775, true);

        \Storage::move("assets/elements/$element");

        return true;
    }

    
    public function is_in_plan($element, $key = null){
        $message = __('This element is not in your current package.');
        $response = ['status' => 1, 'message' => $message];

        if (!$user = \Auth::user()) {
            return ao($response, $key);
        }

        if (!plan("settings.elements.$element", $user->id)) {
            return ao($response, $key);
        }
        $response['status'] = 1;
        return ao($response, $key);
    }

    public static function thumbStyle($element){
        if (!self::has($element)) {
            return false;
        }

        $config = function($key = null) use ($element){
            return \Elements::config($element, "thumbnail.$key");
        };

        $style = 'background: '. $config('background') .'; color: '. $config('i-color') .';';


        return $style;
    }

    public static function galleryImage($element, $image){
        if (!self::has($element)) {
            return false;
        }

        $config = function($key = null) use ($element){
            return \Elements::config($element, $key);
        };

        return self::getPublicAssets($element, 'gallery', $image);
    }


    public static function icon($element){
        if (!self::has($element)) {
            return false;
        }

        $config = function($key = null) use ($element){
            return \Elements::config($element, "thumbnail.$key");
        };

        $icon = '';

        switch ($config('type')) {
            case 'icon':
                $icon .= '<div class="card-thumb shadow-bg shadow-bg-s" style="background: '. $config('background') .'; color: '. $config('i-color') .'"><i class="'. $config('thumbnail') .'"></i></div>';
            break;

            case 'feather':
                $icon .= feather($config('i-color'), $config('i-class'));
            break;


            case 'orion':
                $icon .= '<div class="card-thumb shadow-bg shadow-bg-s" style="background: '. $config('background') .'; color: '. $config('i-color') .'">'. orion($config('svg-orion'), $config('svg-class') . ' stroke-current w-8 h-8 orion-svg-element') .'</div>';
            break;
        }


        return $icon;
    }

    public static function has($element){
        $self = new self();
        $elementDIR = "$self->dir/$element";
        if (is_dir($elementDIR)) {
            return true;
        }

        return false;
    }

    public static function getdir($element, $dir = ''){
        $self = new self();
        $elementDIR = "$self->dir/$element";
        if (is_dir($elementDIR)) {
            return "$elementDIR/$dir";
        }

        return false;
    }

    public static function getPublicAssets($element, $path, $item){
        if (!self::has($element)) {
            return false;
        }
        $location = "assets/image/elements/$element/$path";

        return gs($location, $item);
    }

    public static function getGalleryNames($element){
        $path = self::getdir($element, 'Media/gallery');
        $media = [];

        if (!is_dir($path)) {
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

    public static function getAssetsNames($element){
        $path = self::getdir($element, 'Media/assets');
        $media = [];

        if (!is_dir($path)) {
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

    public static function config($element, $key = null){
        $self = new self();
        if (!$self->has($element)) {
            return false;
        }

        if (file_exists($file = $self->getdir($element, 'config.php')) && \Route::has("sandy-app-$element-create")) {
            $config = file_get_contents($file);
            $config = json_decode($config, true);

            if (!is_array($config)) {
                $config = [];
            }

            return ao($config, $key);
        }

        return false;
    }

    public static function getGalleryConfig($element){
        $self = new self();
        if (!$config = $self->config($element)) {
            return [];
        }

        if (is_array(ao($config, 'gallery'))) {
            return ao($config, 'gallery');
        }

        return [];
    }
    public static function removePublic($element){
        storageDeleteDir($dir = "assets/image/elements/$element");

        return true;
    }

    public static function makePublic($element){
        $path = base_path('sandy/Segment');
        if (!self::has($element)) {
            return false;
        }

        storageDeleteDir($dir = "assets/image/elements/$element");
        $assets = "$path/$element/Media/assets";
        $gallery = "$path/$element/Media/gallery";
        if (!is_dir($gallery) && !is_dir($assets)) {
            return false;
        }

        if (is_dir($gallery)) {
            $gallery_dir = new \DirectoryIterator($gallery);
            foreach ($gallery_dir as $info){
                if (!$info->isDot()) {
                    // Important info
                    $file = $info->getPathname();
                    $name = $info->getFilename();

                    getStoragePutAs("$dir/gallery", new File($file), $name);
                }
            }
        }

        if (is_dir($assets)) {
            $assets_dir = new \DirectoryIterator($assets);
            foreach ($assets_dir as $info){
                if (!$info->isDot()) {
                    // Important info
                    $file = $info->getPathname();
                    $name = $info->getFilename();

                    getStoragePutAs("$dir/assets", new File($file), $name);
                }
            }
        }
        return true;
    }

    public static function putConfig($element, array $config){
        $self = new self();
        if (!$self->has($element)) {
            return false;
        }

        if (file_exists($file = $self->getdir($element, 'config.php'))) {
            $config = \Illuminate\Support\Collection::make($config)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            file_put_contents($file, $config);

            return true;
        }

        return false;
    }

    public function getInstalledPlugins(){
        $plugins = [];

        $directory = new \DirectoryIterator($this->dir);


        foreach ($directory as $info){
            if (!$info->isDot()) {
                $plugin = $info->getFilename();
                $path = $info->getPathname();

                if (file_exists($config = "{$path}/config.php")) {
                    
                    $config = require $config;
                    foreach($config as $key => $value){
                        $plugins[$key] = $value;
                    }
                }
            }
        }



        return $plugins;
    }



    public static function LinkOrElementHtml($user_id, $defaults = []){
        if (!$user = \App\User::find($user_id)) {
            return false;
        }

        return view('mix::include.element-skel', ['user' => $user, 'defaults' => $defaults]);

        $dropInner = function () use ($user_id, $fields){
            $html = '';
                foreach (elements($user_id) as $element):
                    $html .= '
                    <div class="option-row">
                        <input type="radio" name="element" value="'. $element->id .'">
                        <div class="option-meta">
                            <div class="meta-app">
                                '. ElementIcon($element->element) .'
                                <div class="content">
                                    <p class="title">'. $element->name .'</p>
                                    <span>'. __('Added :date', ['date' => Carbon::parse($element->create_at)->format('d F y')]) .'</span>
                                </div>
                                <a href="">View</a>
                            </div>
                        </div>
                    </div>';
                endforeach;
            return $html;
        };

        $html = '<div data-checkbox-wrapper=""><div class="grid grid-cols-2 gap-4 mb-0"><label class="sandy-big-checkbox">
                <input type="radio" name="is_element" class="sandy-input-inner" data-checkbox-open=".element-type" value="1" checked=""><div class="checkbox-inner"><div class="checkbox-wrap"><div class="content"><h1>'. __('Elements') .'</h1><p>'. __('Internal Pages') .'</p></div><div class="icon"><div class="active-dot"><i class="la la-check"></i></div></div></div></div></label>


                <label class="sandy-big-checkbox"><input type="radio" name="is_element" class="sandy-input-inner" data-checkbox-open=".link-type" value="0"><div class="checkbox-inner"><div class="checkbox-wrap"><div class="content"><h1>'. __('External') .'</h1><p>'. __('Enternal link url') .'</p></div><div class="icon"><div class="active-dot"><i class="la la-check"></i></div></div></div></div></label></div>

                <a href="" class="text-sticker mb-5">'. __('Create Element') .'</a>


                <div class="sandy-select is-rounded is-dropup has-media mb-5 element-type" data-checkbox-item><div class="select-box"></div><div class="select-icon"><i class="flaticon2-down"></i></div>

            <div class="select-drop">
                <div class="drop-inner">
                '. $dropInner() .'
                </div>
            </div>
        </div>
        <div class="form-input link-type" data-checkbox-item>
            <label>'. __('Link') .'</label>
            <input type="text" name="link" class="bg-w">
        </div>
    </div>';



        return $html;
    }
}
