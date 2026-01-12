<?php

namespace Modules\Admin\Http\Controllers\Errors;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins;
use App\Payments;

class ErrorLogController extends Controller{
    public function log(){
        $logs = false;
        if (file_exists($path = storage_path('logs/sandy.log'))) {
            $logs = file_get_contents($path);
        }

        return view('admin::errors.sandy-log', ['logs' => $logs]);
    }
}
