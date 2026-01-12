<?php

namespace Modules\Mix\Http\Controllers\Base;

use App\Models\MySession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Modules\Bio\Http\Traits\BioTraits;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, BioTraits;
	public $user;
    public $bio;

	public function __construct(){
        $this->middleware(function ($request, $next) {
	   	   $this->user = auth()->user();
           $this->bio = $this->user;

           MySession::updateUser($this->user->id);

           return $next($request);
        });


        View::composer('*', function ($view){
            $user = user() ?: Auth::user();
            View::share('user', $user);
            View::share('bio', $user);
            View::share('sandy', $this);
        });
	}
}