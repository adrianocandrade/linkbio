<?php

namespace Sandy\Plugins\user_util\Controllers;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route;

class TreeController extends Controller{
    public function tree(){
        return view('Plugin-user_util::tree');
    }
}