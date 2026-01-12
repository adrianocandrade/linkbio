<?php

namespace Sandy\Blocks\course\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function post_new_block(Request $request){
        $yettiblock = new \YettiBlocks;

        if(YettiBlock::where('user', $this->user->id)->where('block', 'course')->first()){
            return back()->with('error', __('Courses block already added.'));
        }
        
        $block = $yettiblock->create_block($this->user->id, 'course', 'My Courses');


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}