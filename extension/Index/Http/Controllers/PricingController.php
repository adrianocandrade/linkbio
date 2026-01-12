<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Plan;

class PricingController extends Controller{
    public function pricing(){
        // Get Plan's skeleton
        $skeleton = function($key = null){
            $skeleton = getOtherResourceFile('plan');

            return ao($skeleton, $key);
        };

        // Get All Plans
        $plans = Plan::orderBy('position', 'ASC')->orderBy('id', 'DESC')->where('status', 1)->get();

        // Return view
        return view('index::pricing.index', ['skeleton' => $skeleton, 'plans' => $plans]);
    }
}