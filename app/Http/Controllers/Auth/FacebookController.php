<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Events\NewUser;
use Illuminate\Http\Request;
use App\User;
use Socialite;

class FacebookController extends Controller{
    public function __construct(){
        $this->middleware('guest');
    }

    public function redirect(){
        if (!config('app.FACEBOOK_ENABLE')) {
            abort(404);
        }
        return Socialite::driver('facebook')->redirect();
    }


    public function callback(Request $request){
        // Try the facebook login
        try {
            // Get facebook user
            $facebook = Socialite::driver('facebook')->user();

            // Check if user exists in our database
            if ($user = User::where('facebook_id', $facebook->id)->first()) {
                // Login the user
                Auth::login($user);

                // Log activity
                logActivity($user->email, 'Login', __('Successful Login with Facebook'));

                if (!empty($redirect = $request->get('redirect'))) {
                    return redirect($redirect);
                }
                // Redirect user to mix
                return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
            }

            // Check if user exists by email
            if ($user = User::where('email', $facebook->email)->first()) {
                $update = User::find($user->id);
                $update->facebook_id = $facebook->id;

                // Save the facebook ID
                $update->save();

                // Login the user
                Auth::login($user);

                // Log activity
                logActivity($user->email, 'Login', __('Successful Login with Facebook'));

                if (!empty($redirect = $request->get('redirect'))) {
                    return redirect($redirect);
                }
                // Redirect user to mix
                return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
            }

            // If user doesnt exists Create them

            $fourSTR = \Str::random(4);

            $username = slugify($facebook->name);
            $username = $username . "_" . $fourSTR;
            $avatar = ['type' => 'url', 'url' => $facebook->avatar];

            // User array
            $array = [
                'name' => $facebook->name,
                'username' => $username,
                'email' => $facebook->email,
                'facebook_id' => $facebook->id,
                'password' => Hash::make(\Str::random(9))
            ];

            $create = User::create($array);
            event(new NewUser($create));


            // Log activity
            logActivity($facebook->email, 'register', __('Successful Account Registration with Facebook'));


            Auth::login($create);

            try {
                // Create blocks
                \Blocks::preset_blocks($create->id);
            } catch (\Exception $e) {
                my_log($e->getMessage());
            }

            if (!empty($redirect = $request->get('redirect'))) {
                return redirect($redirect);
            }
            // Redirect user to mix
            return redirect()->route('user-mix')->with('success', __('Logged in successfully'));

        } catch (\Exception $e) {
            return redirect()->route('user-login')->with('error', $e->getMessage());
            

            // Return custom message alone

            // return redirect()->route('user-login')->with('error', __('Token Expired. Please try again.'));

            // Or out put message
            //return redirect()->route('user-login')->with('error', $e->getMessage());
        }
    }
}
