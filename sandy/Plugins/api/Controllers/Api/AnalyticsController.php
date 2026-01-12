<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\Block;
use App\Models\Blockselement;
use App\Models\MySession;
use App\Models\Visitor;
use App\Models\Linkertrack;

class AnalyticsController extends Controller{
    public function live(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);

        $liveModel = MySession::activity(10)->hasBio($user->id)->get();
        $visitors = MySession::getInsight($user);
        $live = [];

        foreach ($liveModel as $value) {
            $live[] = [
                'user' => $value->user_bio,
                'ip' => $value->ip_address,
                'tracking' => $value->tracking,
                'last_activity' => $value->last_activity,
            ];
        }

        $response = [
            'status' => true,
            'response' => [
                'visitors' => $live,
                'insight' => $visitors,
            ],
        ];

        return Response::json($response);
    }

    public function views(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);

        $insight = Visitor::getInsight($user);

        $response = [
            'status' => true,
            'response' => $insight,
        ];

        return Response::json($response);
    }

    public function clicks(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);

        $linksModel = Linkertrack::topLink($user, null);
        $link = Linkertrack::totalVisits($user);

        $links = [];

        foreach ($linksModel as $key => $value) {
            $links[$key] = $value;
        }

        $response = [
            'status' => true,
            'response' => [
                'links' => $links,
                'insight' => $link,
            ],
        ];

        return Response::json($response);
    }

    public function single_click($slug, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = json_decode(file_get_contents('php://input'), true);


        if (!Linkertrack::where('user', $user->id)->where('slug', $slug)->first()) {
            $response = [
                'status' => false,
                'message' => __('Insight Not Found'),
            ];
            return Response::json($response);
        }

        // Get link insight
        $link = Linkertrack::getLinkInsight($slug, $user);

        $response = [
            'status' => true,
            'response' => $link,
        ];

        return Response::json($response);
    }
}