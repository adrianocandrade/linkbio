<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\TipCollection;

class TipController extends Controller{
    public function index(){
        $tips = TipCollection::where('user', $this->user->id)->get();

        return view('mix::tips.tip-collection', ['tips' => $tips]);
    }
}
