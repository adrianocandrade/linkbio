<?php

namespace Modules\Mix\Http\Controllers\Integrations;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Payments;
use Illuminate\Support\Facades\Mail;
use App\Email;
use App\Models\Highlight;

class IntegrationsController extends Controller
{
    function __construct(){
        parent::__construct();
    }

    public function index(){

        return view('mix::settings.integrations.index');
    }
}
