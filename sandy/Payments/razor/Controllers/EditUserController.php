<?php

namespace Sandy\Payments\razor\controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Sandy\Payments\Payments;
use App\Models\PaymentsSpv;
use Route;
use Modules\Mix\Http\Controllers\Base\Controller;

class EditUserController extends Controller{
    public function edit(){
    	return view('Payment-razor::user.edit');
    }
}