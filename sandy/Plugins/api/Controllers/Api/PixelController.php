<?php

namespace Sandy\Plugins\api\Controllers\Api;

use Illuminate\Routing\Controller;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Route, Response;
use App\User;
use App\Models\Pixel;

class PixelController extends Controller{
    public function pixels(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Get Pixels
        $pixels = Pixel::user($user->id);

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
        $return = $pixels->paginate(
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

    public function pixel($id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Post Pixel
        $pixel = Pixel::where('user', $user->id)->where('id', $id)->first();

        if (!$pixel) {
            return Response::json([
                'status' => false,
                'response' => __("Pixel not found"),
            ]);
        }

        $response = [
            'status' => true,
            'response' => $pixel,
        ];

        // Return json
        return Response::json($response);
    }

    public function delete($id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Post Pixel
        $pixel = Pixel::where('user', $user->id)->where('id', $id)->first();
        if (!$pixel) {
            return Response::json([
                'status' => false,
                'response' => __("Pixel not found"),
            ]);
        }

        $pixel = Pixel::find($pixel->id);
        $pixel->delete();

        $return = __('Pixel deleted Successfully');
        $response = [
            'status' => true,
            'response' => $return,
        ];

        // Return json
        return Response::json($response);
    }

    public function new(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Get All Pixel Templates        
        $skeleton = getOtherResourceFile('pixels');

        // CHeck if can upload
        if (!plan('settings.pixel_codes', $user->id)) {
            return Response::json([
                'status' => false,
                'response' => __("You cant create pixels on this plan."),
            ]);
        }


        // Check if pixel doesnt exceed plan
        $pixelsCount = Pixel::where('user', $user->id)->count();
        if (plan('settings.pixel_limit', $user->id) != -1 && $pixelsCount >= plan('settings.pixel_limit', $user->id)) {
            return Response::json([
                'status' => false,
                'response' => __("You've reached your package limit."),
            ]);
        }

        // Check for string errors
        if (!ao($validate = $this->validatePostString($input), 'status')) {
            return Response::json([
                'status' => false,
                'response' => ao($validate, 'response'),
            ]);
        }

        if (!array_key_exists(ao($input, 'type'), $skeleton)) {
            return Response::json([
                'status' => false,
                'response' => __("Pixel Type is invalid. Kindly visit pixel template section on our api to see pixel types. Pixels types are of: facebook, google_analytics, twitter, etc."),
            ]);
        }

        // Post Pixel
        $pixel = new Pixel;
        $pixel->name = ao($input, 'name');
        $pixel->user = $user->id;
        $pixel->status  = !is_null(ao($input, 'status')) ? ao($input, 'status') : 1;
        $pixel->pixel_id = ao($input, 'pixel_id');
        $pixel->pixel_type = ao($input, 'type');

        $pixel->save();


        $return = [
            'id' => $pixel->id,
            'message' => __('Pixel saved Successfully'),
        ];
        
        $response = [
            'status' => true,
            'response' => $return,
        ];

        return Response::json($response);
    }

    public function editPixel($id, Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Get All Pixel Templates        
        $skeleton = getOtherResourceFile('pixels');

        // Check for string errors
        if (!ao($validate = $this->validatePostString($input), 'status')) {
            return Response::json([
                'status' => false,
                'response' => ao($validate, 'response'),
            ]);
        }

        if (!array_key_exists(ao($input, 'type'), $skeleton)) {
            return Response::json([
                'status' => false,
                'response' => __("Pixel Type is invalid. Kindly visit pixel template section on our api to see pixel types. Pixels types are of: facebook, google_analytics, twitter, etc."),
            ]);
        }

        // Post Pixel
        $pixel = Pixel::where('user', $user->id)->where('id', $id)->first();
        if (!$pixel) {
            return Response::json([
                'status' => false,
                'response' => __("Pixel not found"),
            ]);
        }

        $pixel = Pixel::find($pixel->id);
        $pixel->name = ao($input, 'name');
        $pixel->user = $user->id;
        $pixel->status  = !is_null(ao($input, 'status')) ? ao($input, 'status') : 1;
        $pixel->pixel_id = ao($input, 'pixel_id');
        $pixel->pixel_type = ao($input, 'type');

        $pixel->save();


        $return = [
            'id' => $pixel->id,
            'message' => __('Pixel edited Successfully'),
        ];
        
        $response = [
            'status' => true,
            'response' => $return,
        ];

        return Response::json($response);
    }

    private function validatePostString($input){
        $status = true;
        $return = __('Validation successful');

        if (empty(ao($input, 'type'))) {
            $status = false;
            $return = __('Pixel type is required. Please pass the "type" in your post fields or body.');
        }

        if (empty(ao($input, 'pixel_id'))) {
            $status = false;
            $return = __('Pixel ID is required. Please pass the "pixel_id" in your post fields or body.');
        }

        if (empty(ao($input, 'name'))) {
            $status = false;
            $return = __('Pixel name is required. Please pass the "name" in your post fields or body.');
        }

        $response = [
            'status' => $status,
            'response' => $return,
        ];

        return $response;
    }

    public function template(Request $request){
        // Get User
        $user = User::api($request->s_token)->first();
        // Get Input
        $input = phpInput();

        // Get All Pixel Templates        
        $skeleton = getOtherResourceFile('pixels');


        $return = $skeleton;

        $response = [
            'status' => true,
            'response' => $return,
        ];

        return Response::json($response);
    }
}