<?php

namespace Modules\Admin\Http\Controllers\Users;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class EditUserController extends Controller{
    public function edit($id){
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $users = User::where('id', '!=', $user->id)->limit(3)->get()->shuffle();

        return view('admin::users.edit', ['item' => $user, 'users' => $users]);
    }

    public function deleteUser($id){
        if (!User::deleteUser($id)) {
            return back()->with('error', __('Could not delete the user'));
        }


        return back()->with('success', __('User removed successfully'));
    }


    public function editPost($id, Request $request){
        $user = User::find($id);

        if (!$user) {
            abort(404);
        }

        $username = slugify($request->username);
        $request->merge([
            'username' => $username
        ]);

        // Validate the reuqest
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'username' => 'required|unique:users,username,'.$user->id
        ]);

        // Update our user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->status = $request->status;
        $user->role  = $request->role;



        if (!empty($request->password)) {
            $request->validate([
                'password' => 'min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[@$!%*#?&]/|required|confirmed',
            ]);


            $user->password = Hash::make($request->password);
        }


        $user->save();


        return back()->with('success', __('User Saved Successfully'));
    }
}
