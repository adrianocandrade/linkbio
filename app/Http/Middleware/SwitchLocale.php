<?php

namespace App\Http\Middleware;

use Closure;

class SwitchLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {  
        if (\Cookie::get('sandy_locale')) {
             \App::setLocale(\Cookie::get('sandy_locale'));
        }
        return $next($request);
    }
}
