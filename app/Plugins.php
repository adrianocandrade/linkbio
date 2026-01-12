<?php

namespace App;

use Illuminate\Support\ServiceProvider;

class Plugins{
    private $path;
    private $dir;

    function __construct(){
        $plugins = base_path('sandy/Plugins');
        $this->dir = $plugins;
        $this->path = scandir($plugins);
    }

    public static function has($plugin){
        $self = new self();
        $pluginDir = "$self->dir/$plugin";
        if (is_dir($pluginDir)) {
            return true;
        }

        return false;
    }

    public static function dir($plugin, $dir = ''){
        $self = new self();
        $pluginDir = "$self->dir/$plugin";
        if (is_dir($pluginDir)) {
            return "$pluginDir/$dir";
        }

        return false;
    }

    public static function getdir($plugin, $dir = ''){
        $self = new self();
        $plugindir = "$self->dir/$plugin";
        if (is_dir($plugindir)) {
            return "$plugindir/$dir";
        }

        return false;
    }

    public static function config($plugin, $key = null){
        $self = new self();
        if (!$self->has($plugin)) {
            return false;
        }

        if (file_exists($file = $self->getdir($plugin, 'config.php'))) {
            $config = file_get_contents($file);
            $config = json_decode($config, true);

            if (!is_array($config)) {
                $config = [];
            }

            return ao($config, $key);
        }

        return false;
    }

    public static function staticInstalledPlugins(){
        $self = new self();


        return $self->getInstalledPlugins();
    }
    public function getInstalledPlugins(){
        $self = new self();
        $plugins = [];
        $dir = $this->dir;

        foreach(scandir($path = $dir) as $dir){
            if (file_exists($filepath = "{$path}/{$dir}/config.php")) {
                $plugins[$dir] = $self->config($dir);
            }
        }


        return $plugins;

        foreach ($directory as $info){
            if (!$info->isDot()) {
                $plugin = $info->getFilename();
                $path = $info->getPathname();

                if (file_exists($config = "{$path}/config.php")) {
                    
                    $config = require $config;
                    if (is_array($config)) {
                        foreach($config as $key => $value){
                            $plugins[$key] = $value;
                        }
                    }
                }
            }
        }



        return $plugins;
    }
}
