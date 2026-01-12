<?php

namespace Sandy\Plugins\api\Controllers\Api\Admin;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\PlanPayment;

class PaymentsController extends Controller{
    public function payments(Request $request){
        // Get Input
        $input = phpInput();

        $payments = PlanPayment::orderBy('id', 'DESC');

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

    public function payment($id, Request $request){
        // Get Input
        $input = phpInput();
        $payment = PlanPayment::where('id', $id)->first();

        if (!$payment) {
            return Response::json([
                'status' => false,
                'response' => __("Payment not found"),
            ]);
        }

        $response = [
            'status' => true,
            'response' => $payment,
        ];

        // Return json
        return Response::json($response);
    }
}