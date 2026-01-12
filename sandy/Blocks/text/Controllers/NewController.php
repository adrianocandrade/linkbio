<?php

namespace Sandy\Blocks\text\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;

class NewController extends Controller{
    public function textarea(){


        return view('Blocks-text::textarea');
    }

    public function PostNew(Request $request){
        $blocks = ['heading' => $request->heading, 'content' => $request->content];
        $block = new Block;
        $block->user = $this->user->id;
        $block->block = 'text';
        $block->blocks = $blocks;
        $block->save();

        return redirect()->route('user-mix')->with('success', __('Saved Successfully'));

    }
}