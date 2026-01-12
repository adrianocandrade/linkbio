<?php

namespace Modules\Index\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DiscoverController extends Controller
{
    public function discover(Request $request){
        $pages = \App\Models\Visitor::topUsers();
        return view('index::discover.index', ['pages' => $pages]);
    }
}
