<?php

namespace Sandy\Payments\manual\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Sandy\Payments\Payments;
use App\Models\PaymentsSpv;
use Route;
use Modules\Mix\Http\Controllers\Base\Controller;

class EditAdminController extends Controller{
    public function edit(){
    	return view('Payment-manual::admin.edit');
    }
}