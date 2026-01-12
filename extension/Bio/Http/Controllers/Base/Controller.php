<?php

namespace Modules\Bio\Http\Controllers\Base;

use App\User;
use App\Models\MySession;
use App\Traits\UserBioInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Modules\Bio\Http\Traits\BioTraits;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller extends BaseController{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, UserBioInfo, BioTraits;
}