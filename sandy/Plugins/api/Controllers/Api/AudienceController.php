<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use Modules\Mix\Models\AudienceContact;

class AudienceController extends Controller{
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

        // Contacts
        $query = AudienceContact::where('user_id', $user->id);

        if ($request->has('workspace_id')) {
            $query->where('workspace_id', $request->workspace_id);
        }

        $contacts = $query->paginate(
            $paginate,
            ['*'],
            'page',
            $page
        );

        $contacts = $contacts->toArray();

        $response = [
            'status' => true,
            'response' => $contacts['data'],

            'meta' => [
                'current_page' => ao($contacts, 'current_page'),
                'first_page_url' => ao($contacts, 'first_page_url'),
                'from' => ao($contacts, 'from'),
                'last_page' => ao($contacts, 'last_page'),
                'last_page_url' => ao($contacts, 'last_page_url'),
                'next_page_url' => ao($contacts, 'next_page_url'),
                'path' => ao($contacts, 'path'),
                'per_page' => ao($contacts, 'per_page'),
                'prev_page_url' => ao($contacts, 'prev_page_url'),
                'to' => ao($contacts, 'to'),
                'total' => ao($contacts, 'total'),
            ],
        ];

        return Response::json($response);
    }

    public function single($id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();

        // Contact
        $query = AudienceContact::where('user_id', $user->id)->where('id', $id);

        if ($request->has('workspace_id')) {
            $query->where('workspace_id', $request->workspace_id);
        }

        $contact = $query->first();

        if (!$contact) {
            $response = [
                'status' => false,
                'message' => __('Contact not Found'),
            ];
            return Response::json($response);
        }

        $response = [
            'status' => true,
            'response' => $contact,
        ];

        return Response::json($response);
    }
}
