<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
class FirebaseMessageSWController extends Controller{
    public function sw(Request $request){
        header('Content-Type: application/javascript');


        return response()->view('vendor.push.sw')->header('Content-Type', 'application/javascript');
    }
}
