<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LoginController extends Controller{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(){
        return view('auth.login.login');
    }

    public function loginPost(Request $request){
        // Captcha here
        \SandyCaptcha::validator($request);
        
        if ($this->attemptLogin($request)) {
            $user = auth()->user();


            if ($user->google2fa_enabled) {
                auth()->logout();
                $request->session()->put('2fa:user:id', $user->id);
                return redirect()->route('2fa.index');
            }

            if (!is_admin($user->id) && !$user->status && empty($user->emailToken)) {
                $this->logout($request);

                return redirect()->route('user-login')->with('error', __('This account is not active or has been banned. Please contact support.'));
            }

            // Log user activity
            logActivity($user->email, 'Login', __('Successful Login'));

            if (!empty($redirect = $request->get('redirect'))) {
                return redirect($redirect);
            }

            if (!$this->no_plan($user)) {
                return redirect()->route('user-mix-no-plan')->with('success', __('No plan found.'));
            }

            // Redirct to mix route
            return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
        }else{
            logActivity($request->email, 'Login', __('Login Failed'));

            // Invalid Login
            return back()->with('error', __('Oppes! Invalid credentials'));
        }
    }


    public function no_plan($user){
        if (!$plan_user = \App\Models\PlansUser::where('user_id', $user->id)->first()) {
            $plan = \App\Models\Plan::where('defaults', 1)->where('status', 1)->where('price_type', 'free')->first();

            if ($plan) {
                $activate = ActivatePlan($user->id, $plan->id, null);
                return true;
            }

            return false;
        }


        return true;
    }


    protected function validateLogin(Request $request)
    {
        $messages = [
            'user.required' => 'Email or username cannot be empty',
            'email.exists'      => 'Email or username already registered',
            'username.exists'   => 'Username is already registered',
            'password.required' => 'Password cannot be empty',
        ];

        $request->validate([
            'user' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'username' => 'string|exists:users',
        ], $messages);
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username(){
        $login = request()->input('user');

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        request()->merge([$field => $login]);

        return $field;
    }

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request), 1
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    public function logout(Request $request){
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }
}
