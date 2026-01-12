<?php

namespace Sandy\Plugins\api\Controllers\Api\Admin;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\Plan;

class PlansController extends Controller{
    public function plans(Request $request){
        // Get Input
        $input = phpInput();

        $payments = Plan::orderBy('id', 'DESC');

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

        // Returned Array of Paginate
        $return = $payments->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $return = $return->toArray();

        // Expected Response
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

    public function plan($id, Request $request){
        // Get Input
        $input = phpInput();
        $plan = Plan::where('id', $id)->first();

        if (!$plan) {
            return Response::json([
                'status' => false,
                'response' => __("Plan not found"),
            ]);
        }

        $response = [
            'status' => true,
            'response' => $plan,
        ];

        // Return json
        return Response::json($response);
    }

    public function AddPlanToUser($id, Request $request){
        // Get Input
        $input = phpInput();
        $plan = Plan::where('id', $id)->first();

        if (!$plan) {
            return Response::json([
                'status' => false,
                'response' => __("Plan not found"),
            ]);
        }


        if (!$user = User::find(ao($input, 'user_id'))) {
            return Response::json([
                'status' => false,
                'response' => __("User not found"),
            ]);
        }

        if (!strtotime(ao($input, 'date'))) {
            return Response::json([
                'status' => false,
                'response' => __("Date not valid"),
            ]);
        }

        $user_id = $user->id;

        $duration_time = \Carbon\Carbon::parse(ao($input, 'date'));

        $activate = ActivatePlan($user->id, $plan->id, $duration_time);
        if (!ao($activate, 'status')) {
            return Response::json([
                'status' => false,
                'response' => ao($activate, 'response')
            ]);
        }
        
        $response = [
            'status' => true,
            'response' => __("Plan added to :user", ['user' => $user->name]),
        ];

        // Return json
        return Response::json($response);
    }
}