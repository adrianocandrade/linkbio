<?php

namespace Modules\Admin\Http\Controllers\Users;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class LoginAsController extends Controller{
    public function login($id){
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        \Auth::login($user);


        return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
    }
}
