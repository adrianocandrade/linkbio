<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\PlanPayment;

class PlanController extends Controller{
    public function history(Request $request){
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

        // History
        $history = PlanPayment::where('user', $user->id)->orderBy('id', 'DESC');

        // Returned Array of Paginate
        $return = $history->paginate(
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
}