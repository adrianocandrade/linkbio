<?php

namespace App\Http\Middleware;

use Closure, Response;
use App\User;

class AdminApi{
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
        if (!$user = User::api($token)->admin()->first()) {
            $response = [
                'status' => false,
                'message' => 'You are not authorized to access this api',
            ];

            return Response::json($response);
        }

        // Validate
        $request->merge(['s_token' => $token]);


        // Proceed
        return $next($request);
    }
}
