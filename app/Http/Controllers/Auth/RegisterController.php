<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Email;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\NewUser;

class RegisterController extends Controller{
    public function __construct(){
        $this->middleware('guest')->except('check_username');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email'     => 'required|string|email|unique:users',
            'username'  => 'required|string|max:20|unique:users',
            'password'  => 'required|string|min:8|confirmed',
            'password'  => 'case_diff|numbers|letters|symbols'
        ]);
    }


    protected function validate_password(Request $request){
        $validator = Validator::make($request->all(), [
            'password'  => 'required|string|min:8|case_diff|numbers|letters|symbols'
        ]);

        if ($validator->fails()) {
            return '<div class="text-red-500">'. $validator->errors()->first() .'</div>';
        }
    }

    public function check_username(Request $request){
        $username = $request->username;
        $validator = \Validator::make($request->all(), [
            'username' => 'required|min:2|max:20',
        ]);

        if ($validator->fails()) {
            return '<div class="text-red-500">'. $validator->errors()->first() .'</div>';
        }
        
        if (User::where('username', $username)->first()) {
            return '<div class="text-red-500">The username "'.$username.'" is already taken. 😞</div>';
        }



        return '<div class="text-green-500">"'.$username.'" is available. 🎉</div>';

    }

    public function register(){
        # View the registration page
        return view('auth.register.register');
    }

    public function registerPost(Request $request){
        if (!settings('user.enable_registration')) {
            return back()->with('error', __('Cant proceed with the registration. Registration is disabled.'));
        }
        // Captcha here
        \SandyCaptcha::validator($request);

        // Validate requests
        $this->validator($request->all())->validate();

        # Register user
        event(new Registered($user = $this->create($request->all())));

        if (!empty($redirect = $request->get('redirect'))) {
            return redirect($redirect);
        }

        // Return to login

        return redirect()->route('user-login')->with('success', __('Registration Successful. Please Login.'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data){
        // Array of user to be created
        $username = slugify(ao($data, 'username'));

        $array = [
            'name' => ao($data, 'name'),
            'email' => ao($data, 'email'),
            'username' => $username,
            'password' => Hash::make(ao($data, 'password'))
        ];


        $create = User::create($array);

        // Send welcome mail
        event(new NewUser($create));
        // Send admin mails

        dispatch(function () use($create) {
            // Check if email activation is active
            $this->emailActivation($create);
        });


        // Log activity
        logActivity($create->email, 'register', __('Successful Account Registration'));
        // Create blocks
        try {
            // Create blocks
            \Blocks::preset_blocks($create->id);
        } catch (\Exception $e) {
            my_log($e->getMessage());
        }
    }


    private function emailActivation($user){
        // Check if require email activation
        if (!settings('user.email_verification')) {
            return false;
        }

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
    }
}
