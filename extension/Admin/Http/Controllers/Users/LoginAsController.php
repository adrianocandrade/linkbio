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

        // Store admin session
        session(['admin_impersonator' => \Auth::id()]);

        \Auth::login($user);


        return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
    }
    public function returnToAdmin(){
        if(session()->has('admin_impersonator')){
            $adminId = session('admin_impersonator');
            $admin = User::find($adminId);

            if($admin){
                \Auth::login($admin);
                session()->forget('admin_impersonator');
                return redirect()->route('admin-dashboard')->with('success', __('Welcome back Admin'));
            }
        }
        
        return redirect('/')->with('error', __('Action unauthorized'));
    }
}
