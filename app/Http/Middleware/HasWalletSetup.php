<?php

namespace App\Http\Middleware;

use Closure, Response;
use App\User;

class HasWalletSetup{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        if ($request->user() && !\Wallet::wallet_setup($request->user()->id)) {
            return redirect()->route('wallet-setup');
        }


        // Proceed
        return $next($request);
    }
}
