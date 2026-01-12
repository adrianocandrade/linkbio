<?php

namespace Modules\Admin\Http\Controllers\Base;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	public function __construct(){
        $this->middleware('is_admin');
	}
}