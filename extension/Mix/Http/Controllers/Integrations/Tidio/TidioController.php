<?php

namespace Modules\Mix\Http\Controllers\Integrations\Tidio;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Payments;
use Illuminate\Support\Facades\Mail;
use App\Email;
use App\Models\Highlight;

class TidioController extends Controller{
    public function index(){

        return view('mix::settings.integrations.tidio.index');
    }

    public function post(Request $request){
        $user = \App\User::find($this->user->id);
        $integrations = $user->integrations;


        if (!empty($integrations_loop = $request->integrations)) {
            foreach ($integrations_loop as $key => $value) {
                $integrations[$key] = $value;
            }
        }


        $user->integrations = $integrations;
        $user->save();


        return back()->with('success', __('Saved successfully'));
    }
}
