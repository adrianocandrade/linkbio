<?php

namespace App\Http\Livewire\Mix;

use Livewire\Component;

class LinkShortener extends Component
{

    public $user;
    public $user_id;


    public $generated = false;
    public $shortened = '';

    public $link;

    
    public function hydrate(){
        $this->emit('changed_state');
    }

    public function shorten(){
        $this->validate([
            'link' => 'required'
        ]);

        $scheme = $this->addscheme($this->link);
        $linker = linker($scheme, $this->user_id);

        $this->shortened = $linker;
        $this->generated = true;
    }

    public function restart(){
        
        $this->shortened = '';
        $this->generated = false;
    }

    public function addscheme($url){
        $url = addHttps($url);

        if (validate_url($url)) {
            return $url;
        }


        return false;
    }

    public function mount(){

    }

    public function render()
    {
        return view('livewire.mix.link-shortener');
    }
}
