<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\NewUser;
use App\User;
use Socialite;

class GoogleController extends Controller{
    public function __construct(){
        $this->middleware('guest');
    }

    public function redirect(){
        if (!config('app.GOOGLE_ENABLE')) {
            abort(404);
        }
        return Socialite::driver('google')->redirect();
    }


    public function callback(Request $request){
        // Try the google login
        try {

            // Get google user
            $google = Socialite::driver('google')->user();

            // Check if user exists in our database
            if ($user = User::where('google_id', $google->id)->first()) {
                // Login the user
                Auth::login($user);

                // Log activity
                logActivity($user->email, 'Login', __('Successful Login with Google'));

                if (!empty($redirect = $request->get('redirect'))) {
                    return redirect($redirect);
                }
                // Redirect user to mix
                return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
            }

            // Check if user exists by email
            if ($user = User::where('email', $google->email)->first()) {
                $update = User::find($user->id);
                $update->google_id = $google->id;

                // Save the google ID
                $update->save();

                // Login the user
                Auth::login($user);

                // Log activity
                logActivity($user->email, 'Login', __('Successful Login with Google'));

                if (!empty($redirect = $request->get('redirect'))) {
                    return redirect($redirect);
                }
                // Redirect user to mix
                return redirect()->route('user-mix')->with('success', __('Logged in successfully'));
            }

            // If user doesnt exists Create them

            $fourSTR = \Str::random(4);

            $username = slugify($google->name);
            $username = $username . "_" . $fourSTR;
            $avatar = ['type' => 'url', 'url' => $google->avatar];

            // User array
            $array = [
                'name' => $google->name,
                'username' => $username,
                'avatar_settings' => $avatar,
                'email' => $google->email,
                'google_id' => $google->id,
                'password' => Hash::make(\Str::random(9))
            ];

            $create = User::create($array);
            event(new NewUser($create));


            // Log activity
            logActivity($google->email, 'register', __('Successful Account Registration with Google'));


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
