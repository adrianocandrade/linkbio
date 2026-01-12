<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Events\WelcomeMail;
use Illuminate\Http\Request;
use App\User;
use Socialite;
use App\Email;

class ActivationController extends Controller{
    public function activate($token){
        if (!$user = \App\User::where('emailToken', $token)->first()) {
            abort(404);
        }

        $user = \App\User::find($user->id);
        $user->emailToken = null;
        $user->save();

        return redirect()->route('user-login')->with('success', __('Email activated successfully'));
    }

    public function needActivation(){
        // Check if require email activation
        if (!settings('user.email_verification')) {
            abort(404);
        }

        return view('auth.need-activation');
    }

    public function ResendActivation(Request $request){
        // Captcha here
        \SandyCaptcha::validator($request);

        if (!\Auth::check()) {
            abort(404);
        }

        // Check if require email activation
        if (!settings('user.email_verification')) {
            return false;
        }

        $user = \Auth::user();
        // Send activation
        $token = md5(microtime());
        // User
        $user = User::find($user->id);
        $user->emailToken = $token;
        $user->save();
        // Send mail

        $email = new Email;
        $template = $email->template('account/Activation', ['user' => $user]);
        $array = [
            'to'    => $user->email,
            'subject' => __('Email Activation'),
            'body' => $template
        ];

        $email->send($array);

        // Log activity
        logActivity($user->email, 'email', __('Email activation sent Successfully. :token', ['token' => $user->emailToken]));

        return back()->with('success', __('Email activation sent Successfully. Check your inbox.'));
    }
}