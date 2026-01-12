<?php

namespace Sandy\Segment\guestbook\Services;
use Illuminate\Support\ServiceProvider;
use Route;

class Services extends ServiceProvider{
    public function boot(){
        // Admin Menu

    }
    public function register(){
        Route::matched(function(){
            $array = [
                'guestbook' => [
                    //'render' => route('sandy-app-guestbook-render'),
                ],
            ];

            $glob = BioGlobal($array);
        });
    }
}