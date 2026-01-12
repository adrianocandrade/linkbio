<?php

namespace Modules\Mix\Http\Controllers\Plans;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;

class NoPlanController extends Controller{
    public function index(){
        if ($plan_user = \App\Models\PlansUser::where('user_id', $this->user->id)->first()) {
            abort(404);
        }

        return view('mix::plan.no-plan');
    }
}
