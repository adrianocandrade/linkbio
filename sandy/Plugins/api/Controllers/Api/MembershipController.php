<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use Modules\Mix\Models\Membership;

class MembershipController extends Controller{
    public function retrieve(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        $input = phpInput();
        
        // Page
        $page = (int) ao($input, 'page');
        if (!is_int($page)) {
            $page = 1;
        }

        // Paginate
        $paginate = (int) ao($input, 'results_per_page');
        if (!in_array($paginate, [10, 25, 50, 100, 250])) {
            $paginate = 10;
        }

        // Plans
        $query = Membership::where('user_id', $user->id);

        if ($request->has('workspace_id')) {
            $query->where('workspace_id', $request->workspace_id);
        }

        $plans = $query->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $plans = $plans->toArray();

        $response = [
            'status' => true,
            'response' => $plans['data'],

            'meta' => [
                'current_page' => ao($plans, 'current_page'),
                'first_page_url' => ao($plans, 'first_page_url'),
                'from' => ao($plans, 'from'),
                'last_page' => ao($plans, 'last_page'),
                'last_page_url' => ao($plans, 'last_page_url'),
                'next_page_url' => ao($plans, 'next_page_url'),
                'path' => ao($plans, 'path'),
                'per_page' => ao($plans, 'per_page'),
                'prev_page_url' => ao($plans, 'prev_page_url'),
                'to' => ao($plans, 'to'),
                'total' => ao($plans, 'total'),
            ],
        ];

        return Response::json($response);
    }

    public function single($id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        // Plan
        $query = Membership::where('user_id', $user->id)->where('id', $id);

        if ($request->has('workspace_id')) {
            $query->where('workspace_id', $request->workspace_id);
        }

        $plan = $query->first();

        if (!$plan) {
            $response = [
                'status' => false,
                'message' => __('Plan not Found'),
            ];
            return Response::json($response);
        }

        $response = [
            'status' => true,
            'response' => $plan,
        ];

        return Response::json($response);
    }
}
