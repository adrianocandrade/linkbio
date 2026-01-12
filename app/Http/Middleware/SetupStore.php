<?php

namespace App\Http\Middleware;

use Closure, Response;
use App\User;

class SetupStore{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if ($request->user() && !\App\Shop\Shop::has_store_setup($request->user()->id)) {
            return redirect()->route('user-mix-shop-setup');
        }


        // Proceed
        return $next($request);
    }
}
