<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Events\NewUser;
use App\Models\Authactivity;
use App\User;

class UsersController extends Controller{
    public function all(Request $request){
        $users = $this->Usersfilter($request);

        return view('admin::users.all', ['users' => $users]);
    }

    public function Usersfilter ($request){
        $users = new User;

        // Paginate results per page
        $paginate = (int) $request->get('per_page');
        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        // Order Type
        $order_type = $request->get('order_type');
        if (!in_array($order_type, ['ASC', 'DESC'])) {
            $order_type = 'DESC';
        }
        // Order By
        $order_by = $request->get('order_by');
        if (!in_array($order_by, ['created_at', 'lastActivity', 'email', 'name'])) {
            $order_by = 'created_at';
        }

        $users = $users->orderBy($order_by, $order_type);

        //Query Type
        $searchBy = $request->get('search_by');
        if (!in_array($searchBy, ['email', 'name'])) {
            $searchBy = 'email';
        }

        // Query
        if (!empty($query = $request->get('query'))) {
            $users = $users->where($searchBy, 'LIKE','%'.$query.'%');
        }

        // Country
        if (!empty($country = $request->get('country'))) {
            $users = $users->where('lastCountry', $country);
        }

        // Status
        if (!empty($status = $request->get('status'))) {
            if (in_array($status, ['active', 'disabled'])) {

                switch ($status) {
                    case 'active':
                        $status = 1;
                    break;

                    case 'disabled': 
                        $status = 0;
                    break;
                }

                $users = $users->where('status', $status);
            }
        }

        if (!empty($plan = $request->get('plan'))) {
            $users = $users->whereHas('plan', function($q) use ($plan){
                $plan = (int) $plan;
                $q->where('plan_id', '=', $plan);
            });
        }

        // Returned Array of Paginate
        $users = $users->paginate(
            $paginate,
        )->onEachSide(1)->withQueryString();


        // Filter Plan
        return $users;
    }

    public function newUser(Request $request){
        $validate = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email'     => ['required', 'string', 'email', 'unique:users'],
            'username'  => ['required', 'string', 'max:20', 'unique:users'],
            'password'  => ['required', 'string', 'min:8', 'regex:/[@$!%*#?&]/', 'regex:/[A-Z]/', 'regex:/[a-z]/'],
        ]);

        $validate = $validate->validate();

        // Create User
        $rand = \Str::random(4);
        $username = "{$request->username}_$rand";
        $username = slugify($username);

        $array = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $username,
            'status' => 1,
            'password' => Hash::make($request->password)
        ];

        $create = User::create($array);

        // Create Default Workspace
        $workspace = \App\Models\Workspace::create([
            'user_id' => $create->id,
            'name' => 'My Workspace',
            'slug' => $create->username,
            'is_default' => 1,
            'status' => 1
        ]);

        // Send welcome mail
        event(new NewUser($create));

        // Log activity
        logActivity($create->email, 'register', __('Successful Account Registration.'));

        try {
            // Create blocks
            \Blocks::preset_blocks($create->id);
        } catch (\Exception $e) {
            my_log($e->getMessage());
        }

        // Return Back
        return back()->with('success', __('User Created Successfully.'));
    }
}
