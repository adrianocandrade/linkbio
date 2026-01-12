<?php

namespace Modules\Docs\Http\Controllers\Support;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\SupportMessage;
use App\Models\SupportConversation;

class MyRequestController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function view(Request $request){

        $support = SupportConversation::where('user', $this->user->id)->orderBy('id', 'DESC')->get();

        // Return view
        return view('docs::support.requests', ['support' => $support]);
    }
}
