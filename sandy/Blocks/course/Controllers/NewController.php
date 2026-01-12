<?php

namespace Sandy\Blocks\course\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class NewController extends Controller{
    public $name = 'course';
    public function create(){

        return redirect()->route('user-mix-course-dashboard');


        return view("Blocks-$this->name::create");
    }

    public function skel(Request $request){
        $route = route('user-mix-block-element-post', $this->name);

        if (!empty($block = $request->get('block'))) {
            $route = route('user-mix-block-element-new', $block);
        }

        return view("Blocks-$this->name::skel.create-skel", ['route' => $route]);
    }
}