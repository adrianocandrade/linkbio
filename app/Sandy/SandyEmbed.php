<?php

namespace App\Sandy;
use Illuminate\Http\File;
use App\Models\SandyEmbedStore;
use Embed\Embed;

class SandyEmbed{
    public $url;
    public $objects = [];

    function __construct($url){
        $this->url = $url;
    }


    public function fetch(){
        $this->get_dom();

        return $this->objects;
    }


    private function get_dom(){
        if ($store = $this->fetch_stored()) {
            return $this->objects = $store->data;
        }

        $embed = new Embed();
        $embed->setSettings([
            'twitch:parent' => url('/'), //Required to embed twitch videos as iframe
        ]);
        $info = $embed->get($this->url);

        // Website
        $this->objects['w'] = parse($info->providerUrl, 'host');
        $this->objects['fw'] = (string) $info->url;

        // Title
        if ($info->title) {
            $this->objects['t'] = $info->title;
        }


        // Description
        if ($info->description) {
            $this->objects['d'] = $info->description;
        }

        // Seo Image
        if ($info->image) {
            $this->objects['s'] = (string) $info->image;
        }

        // Favicon
        if ($info->favicon) {
            $this->objects['f'] = (string) $info->favicon;
        }

        if ($info->code) {
            $this->objects['h'] = $info->code->html;
        }

        //$this->embed_content($this->type);

        $this->store();
    }


    private function embed_content(){
        $path = base_path('sandy/Embed');

        ob_start();
            include("$path/content.php");
        $content = ob_get_clean();

        $fetch['c'] = $content;

        return $fetch;
    }

    private function fetch_stored(){
        if (!$store = SandyEmbedStore::where('link', $this->url)->first()) {
            return false;
        }

        if ($store->created_at->diffInHours() > 24) {
            $store->delete();


            return false;
        }

        return $store;
    }

    private function store(){
        if ($store = SandyEmbedStore::where('link', $this->url)->first()) {
            return false;
        }

        $new = new SandyEmbedStore;
        $new->link = $this->url;
        $new->data = $this->objects;
        $new->save();
    }
}
