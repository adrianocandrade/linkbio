<?php

namespace App\Http\Middleware;

use Closure, Response;
use App\User;

class UserApi{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        // Get Token
        $token = getBearerToken();

        // Check if plan has api

        // Validate
        if (!$user = User::api($token)->first()) {
            $response = [
                'status' => false,
                'message' => 'Invalid Key',
            ];

            return Response::json($response);
        }


        if (!plan('settings.api', $user->id)) {
            $response = [
                'status' => false,
                'message' => __('Your Plan Does Not Support Api Access. Please Upgrade.'),
            ];

            return Response::json($response);
        }

        // Validate
        $request->merge(['s_token' => $token]);


        // Proceed
        return $next($request);
    }
}
