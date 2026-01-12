<?php

namespace Sandy\Payments\paystack\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Sandy\Payments\Payments;
use App\Models\PaymentsSpv;
use Route;
use Modules\Mix\Http\Controllers\Base\Controller;

class EditAdminController extends Controller{
    public function edit(){
    	return view('Payment-paystack::admin.edit');
    }
}