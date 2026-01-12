<?php

namespace Sandy\Blocks\shop\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function post_new_block(Request $request){

        $yettiblock = new \YettiBlocks;

        if(YettiBlock::where('user', $this->user->id)->where('block', 'shop')->first()){
            return back()->with('error', __('Shop block already added.'));
        }
        
        $block = $yettiblock->create_block($this->user->id, 'shop', 'My Shop');


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}