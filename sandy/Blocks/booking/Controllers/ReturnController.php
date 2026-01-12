<?php

namespace Sandy\Blocks\booking\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class ReturnController extends Controller{

    public function return(Request $request){


        return redirect()->route('sandy-blocks-shop-mix-view');
    }
}