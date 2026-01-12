<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;

class UserController extends Controller{
    public function retrieve(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

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


    public function activities(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);

        $page = (int) ao($input, 'page');

        if (!is_int($page)) {
            $page = 1;
        }

        $paginate = (int) ao($input, 'results_per_page');

        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        // Totol Logins
        $totalLogin = \App\Models\Authactivity::where('user', $user->id);

        if ($type = ao($input, 'type')) {
            $totalLogin->where('type', $type);
        }

        $return = $totalLogin->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $return = $return->toArray();

        $response = [
            'status' => true,
            'response' => ao($return, 'data'),

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
}