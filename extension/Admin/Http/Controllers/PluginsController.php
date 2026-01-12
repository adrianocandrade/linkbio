<?php

namespace Modules\Admin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Plugins;
use App\Payments;

class PluginsController extends Controller{
    public function types(){


        return view('admin::plugins.types');
    }
}
