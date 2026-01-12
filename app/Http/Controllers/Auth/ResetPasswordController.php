<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use App\User;
use App\Email;

class ResetPasswordController extends Controller{
    function __construct(){
        $this->middleware('guest');
    }


    public function request (){

        return view('auth.passwords.request');
    }

    public function requestPost (Request $request) {
        // Captcha here
        \SandyCaptcha::validator($request);

        // Validate request

        $request->validate([
            'email' => 'required|email'
        ]);

        // Check if user exists

        if (!$user = User::where('email', $request->email)->first()) {
            return back()->with('error', __('Email not found'));
        }

        // Delete all password requests if exists
        PasswordReset::where('email', $request->email)->delete();

        // Insert new password reset
        $reset = new PasswordReset;
        $reset->email = $request->email;
        $reset->token = md5(time().rand());
        $reset->save();

        // Send email
        $this->sendMail($user, $reset->token);

        //

        return back()->with('success', __('A link has been sent to your email. Kindly check your inbox to reset your password.'));
    }

    private function sendMail($user, $token){
        $email = new Email;
        $template = $email->template('account/request_password_reset_token', ['user' => $user, 'token' => $token]);

        $array = [
            'to' => $user->email,
            'subject' => __('Reset your password'),
            'body' => $template
        ];

        $send = $email->send($array);
    }



    public function reset($token){
        if (!$password = PasswordReset::where('token', $token)->first()) {
            abort(404);
        }

        return view('auth.passwords.reset', ['password' => $password]);
    }

    public function resetPost($token, Request $request){
        //Validate input
        $request->validate([
            'password' => 'min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*#?&]/|required|confirmed',
        ]);

        //
        if (!$password = PasswordReset::where('token', $token)->first()) {
            return back()->with('error', __('No token found'));
        }

        $user = User::where('email', $password->email)->first();
        // Check if user exists
        if (!$user) return back()->with('error', __('Email not found'));

        $user->password = Hash::make($request->password);
        $user->update();

        // Delete the token
        PasswordReset::where('email', $user->email)->delete();

        // Login the user
        Auth::login($user);

        //

        return redirect()->route('user-mix')->with('success', __('Password reset was succssful'));
    }
}
