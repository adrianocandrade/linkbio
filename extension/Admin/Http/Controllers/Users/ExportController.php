<?php

namespace Modules\Admin\Http\Controllers\Users;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;

class ExportController extends Controller{
    public function export_as_csv(){
        $array = \App\User::get()->toArray();
        $col = ['id', 'email', 'name', 'username', 'facebook_id', 'google_id', 'status', 'lastActivity', 'lastCountry', 'lastAgent', 'api', 'plan', 'plandue', 'created_at'];

        return normal_export_to_csv($array, $col, 'users');
    }
}
