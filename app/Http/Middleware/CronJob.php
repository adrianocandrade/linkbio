<?php

namespace App\Http\Middleware;

use Closure;

class CronJob
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
       if (is_installed() && !settings('cron.type')) {
         \App\Cron::cron();
       }
       return $next($request);
    }
}
