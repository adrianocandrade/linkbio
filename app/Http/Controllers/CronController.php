<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Linkertrack;
use App\Models\Linker;

class CronController extends Controller{
    public function cron(){
        \App\Cron::cron();


        abort(404);
    }
}
