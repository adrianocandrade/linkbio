<?php
namespace Modules\Mix\Http\Controllers\Onboard;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use Illuminate\Support\Facades\Hash;

class OnboardingController extends Controller{
    public function wizard(){
        return view('mix::onboard.wizard');
    }
}
