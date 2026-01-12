<?php

namespace Sandy\Plugins\api\Controllers\Api\Admin;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\Pixel;

class UsersController extends Controller{
    public function all(Request $request){
        // Get Input
        $input = phpInput();

        $users = new User;

        // Page
        $page = (int) ao($input, 'page');
        if (!is_int($page)) {
            $page = 1;
        }

        // Paginate results per page
        $paginate = (int) ao($input, 'results_per_page');
        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        $searchBy = (string) ao($input, 'search_by');
        if (!in_array($searchBy, ['email', 'name'])) {
            $searchBy = 'email';
        }
        // Query
        if (!empty($query = ao($input, 'search'))) {
            $users = $users->where($searchBy, 'LIKE','%'.$query.'%');
        }

        // Order Type
        $order_type = (string) ao($input, 'order_type');
        if (!in_array($order_type, ['ASC', 'DESC'])) {
            $order_type = 'DESC';
        }
        // Order By
        $order_by = (string) ao($input, 'order_by');
        if (!in_array($order_by, ['created_at', 'lastActivity', 'email', 'name'])) {
            $order_by = 'created_at';
        }

        $users = $users->orderBy($order_by, $order_type);

        // Returned Array of Paginate
        $paginate_items = $users->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $data = [];

        $return = $paginate_items->toArray();

        foreach ($paginate_items as $user) {
            // Totol Logins
            $totalLogin = \App\Models\Authactivity::where('user', $user->id)->where('type', 'Login')->count();

            $background_settings = $user->background_settings;
            $background_settings['video']['video'] = getStorage('media/bio/background', ao($background_settings, 'video.video'));

            $background_settings['image']['image'] = getStorage('media/bio/background', ao($background_settings, 'image.image'));

            $soical = $user->social;
            $seo = $user->seo;
            $seo['opengraph_image'] = gs('media/bio/seo', ao($seo, 'opengraph_image'));

            $data[] = [
                    'id' => $user->id,
                    'email' => $user->email,
                    'name' => $user->name,
                    'bio' => $user->bio,
                    'username' => $user->username,
                    'avatar' => avatar($user->id),
                    'plan_name' => plan('name', $user->id),
                    'plan_due' => plan('plan_due_string', $user->id),

                    'is_active' => $user->status,

                    'seo' => $seo,
                    'social' => $soical,

                    'customize' => [
                        'font' => $user->font,
                        'theme' => $user->theme,
                        'button_background_color' => ao($user->color, 'button_background'),
                        'button_text_color' => ao($user->color, 'button_color'),
                        'texts_color' => ao($user->color, 'text'),
                        'radius' => ao($user->settings, 'radius'),
                        'bio_align' => ao($user->settings, 'bio_align'),
                    ],

                    'background' => [
                        'type' => $user->background,
                        'settings' => $background_settings,
                    ],

                    'lastActivity' => $user->lastActivity,
                    'lastAgent' => $user->lastAgent,
                    'lastCountry' => $user->lastCountry,
                    'total_login' => $totalLogin, 
            ];
        }

        // Expected Response
        $response = [
            'status' => true,
            'response' => $data,

            'meta' => [
                'current_page' => ao($return, 'current_page'),
                'first_page_url' => ao($return, 'first_page_url'),
                'from' => ao($return, 'from'),
                'last_page' => ao($return, 'last_page'),
                'last_page_url' => ao($return, 'last_page_url'),
                'next_page_url' => ao($return, 'next_page_url'),
                'path' => ao($return, 'path'),
                'per_page' => ao($return, 'per_page'),
                'prev_page_url' => ao($return, 'prev_page_url'),
                'to' => ao($return, 'to'),
                'total' => ao($return, 'total'),
            ],
        ];

        return Response::json($response);
    }

    public function singleUser($user_id){
        // Get User
        $user = User::find($user_id);
        if (!$user) {
            return Response::json([
                'status' => false,
                'response' => __("User not found"),
            ]);
        }


        // Totol Logins
        $totalLogin = \App\Models\Authactivity::where('user', $user->id)->where('type', 'Login')->count();


        $background_settings = $user->background_settings;
        $background_settings['video']['video'] = getStorage('media/bio/background', ao($background_settings, 'video.video'));

        $background_settings['image']['image'] = getStorage('media/bio/background', ao($background_settings, 'image.image'));

        $soical = $user->social;
        $seo = $user->seo;
        $seo['opengraph_image'] = gs('media/bio/seo', ao($seo, 'opengraph_image'));


        $response = [
            'status' => true,
            'response' => [
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'bio' => $user->bio,
                'username' => $user->username,
                'avatar' => avatar($user->id),
                'plan_name' => plan('name', $user->id),
                'plan_due' => plan('plan_due_string', $user->id),

                'is_active' => $user->status,

                'seo' => $seo,
                'social' => $soical,

                'customize' => [
                    'font' => $user->font,
                    'theme' => $user->theme,
                    'button_background_color' => ao($user->color, 'button_background'),
                    'button_text_color' => ao($user->color, 'button_color'),
                    'texts_color' => ao($user->color, 'text'),
                    'radius' => ao($user->settings, 'radius'),
                    'bio_align' => ao($user->settings, 'bio_align'),
                ],

                'background' => [
                    'type' => $user->background,
                    'settings' => $background_settings,
                ],

                'lastActivity' => $user->lastActivity,
                'lastAgent' => $user->lastAgent,
                'lastCountry' => $user->lastCountry,
                'total_login' => $totalLogin, 
            ],
        ];


        return Response::json($response);
    }

    public function update($user_id, Request $request){
        // Get Input
        $input = phpInput();
        $user = User::find($user_id);
        if (!$user) {
            return Response::json([
                'status' => false,
                'response' => __("User not found"),
            ]);
        }

        // Set Variables
        $name = !empty(ao($input, 'name')) ? ao($input, 'name') : $user->name;
        $email = !empty(ao($input, 'email')) ? ao($input, 'email') : $user->email;
        $password = ao($input, 'password');
        $status = ao($input, 'status');
        $role = ao($input, 'role');

        if (!in_array($role, ['1', '0'])) {
            $role = $user->role;
        }

        if (!in_array($status, ['1', '0'])) {
            $status = $user->status;
        }

        // Check for string errors
        if (!ao($validate = $this->validateUpdateUserString($input, $user->id), 'status')) {
            return Response::json([
                'status' => false,
                'response' => ao($validate, 'response'),
            ]);
        }

        $user->name = $name;
        $user->email = $email;
        $user->status = $status;
        $user->role = $role;

        if (!empty($password)) {
            $user->password = \Hash::make($password);
        }

        $user->save();


        $response = [
            'status' => true,
            'response' => 'User updated',
        ];

        // Return json
        return Response::json($response);
    }

    public function delete($user_id, Request $request){
        // Get Input
        $input = phpInput();
        $status = true;
        $return = __('User deleted Successfully');

        $user = User::find($user_id);
        if (!$user) {
            return Response::json([
                'status' => false,
                'response' => __("User not found"),
            ]);
        }

        if (!User::deleteUser($user->id)) {
            $status = false;
            $return = __('Could not delete the user');
        }

        $response = [
            'status' => $status,
            'response' => $return,
        ];

        // Return json
        return Response::json($response);
    }

    public function newUser(Request $request){
        // Get Input
        $input = phpInput();

        // Check for string errors
        if (!ao($validate = $this->validateNewUserString($input), 'status')) {
            return Response::json([
                'status' => false,
                'response' => ao($validate, 'response'),
            ]);
        }

        $name = slugify(ao($input, 'name'));
        $username = "{$name}_".\Str::random(4);

        $newUser = new User;
        $newUser->name = ao($input, 'name');
        $newUser->username = $username;
        $newUser->email = ao($input, 'email');
        $newUser->password = \Hash::make(ao($input, 'password'));

        $newUser->save();

        logActivity($newUser->email, 'register', __('Successful Account Registration.'));

        try {
            // Create blocks
            \Blocks::preset_blocks($newUser->id);
        } catch (\Exception $e) {
            my_log($e->getMessage());
        }

        $return = [
            'id' => $newUser->id,
            'message' => __('New user created'),
        ];
        
        $response = [
            'status' => true,
            'response' => $return,
        ];

        return Response::json($response);
    }

    private function validateUpdateUserString($input, $user_id){
        $status = true;
        $return = __('Validation successful');

        if (empty($input)) {
            $status = false;
            $return = 'Validation Failed';
        }

        if (!empty($name = ao($input, 'name'))) {
            $validator = \Validator::make(['name' => $name], ['name' => 'min:1|required|string']);

            if ($validator->fails()) {
                $status = false;
                $return = $validator->errors()->first();
            }
        }

        if (!empty($email = ao($input, 'email'))) {
            $validator = \Validator::make(['email' => $email], ['email' => 'required|email|unique:users,email,'.$user_id]);

            if ($validator->fails()) {
                $status = false;
                $return = $validator->errors()->first();
            }
        }

        if (!empty($password = ao($input, 'password'))) {
            $validator = \Validator::make(['password' => $password], ['password' => 'min:8|required']);

            if ($validator->fails()) {
                $status = false;
                $return = $validator->errors()->first();
            }
        }

        $response = [
            'status' => $status,
            'response' => $return,
        ];

        return $response;
    }

    private function validateNewUserString($input){
        $status = true;
        $return = __('Validation successful');

        $validate = [
            'name' => ao($input, 'name'),
            'email' => ao($input, 'email'),
            'password' => ao($input, 'password')
        ];

        $validator = \Validator::make($validate, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'min:8|required'
        ]);

        if ($validator->fails()) {
            $status = false;
            $return = $validator->errors()->first();
        }

        $response = [
            'status' => $status,
            'response' => $return,
        ];

        return $response;
    }
}