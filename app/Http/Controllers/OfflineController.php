<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;

class OfflineController extends Controller{

    public function offline(){


        return view('vendor.pwa.offline');
    }
}
