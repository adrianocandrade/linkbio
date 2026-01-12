<?php

namespace Modules\Install\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function user(){
        return view('install::steps.user');
    }


    protected function validator(array $data){
        return \Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'unique:users'],
            'username'  => ['required', 'string', 'max:20', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'confirmed', 'regex:/[@$!%*#?&]/', 'regex:/[A-Z]/', 'regex:/[a-z]/'],
        ]);
    }

    public function user_save(Request $request){
        // Validate requests
        $this->validator($request->all())->validate();

        $data = $request->all();

        // Array of user to be created
        $username = slugify(ao($data, 'username'));

        $array = [
            'name' => ao($data, 'name'),
            'email' => ao($data, 'email'),
            'username' => $username,
            'role' => 1,
            'password' => Hash::make(ao($data, 'password'))
        ];
        $create = User::create($array);
        // Create blocks
        try {
            // Create blocks
            \Blocks::preset_blocks($create->id);
        } catch (\Exception $e) {
            
        }
        Auth::login($create);

        // Last Stuff
        $update_env = [
            'APP_DEBUG' => false,
            'APP_ENV' => 'production',
            'APP_INSTALL' => 1,
            'SESSION_DRIVER' => 'database',
            'APP_URL' => url('/')
        ];
        env_update($update_env);



        return view('install::steps.finalize');
    }
}
