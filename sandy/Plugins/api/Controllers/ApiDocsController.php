<?php

namespace Sandy\Plugins\api\Controllers;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route;

class ApiDocsController extends Controller{
    public function api(){
        return view('Plugin-api::docs.api');
    }
}