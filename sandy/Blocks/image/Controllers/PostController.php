<?php

namespace Sandy\Blocks\image\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function post_new_block(Request $request){
        $yettiblock = new \YettiBlocks;
        
        $content = [
            'caption' => 'This is Fascinating!',
            'alt' => 'Perfect page builder for creatives & get to do more with a linkinbio',
        ];

        $thumbnail = [
            'type' => 'external',
            'upload' => null,
            'link' => random_avatar(\Str::random(10), 'adventurer-neutral')
        ];

        $block = $yettiblock->create_block($this->user->id, 'image', 'My New Image Block');
        $yettiblock->post_blocks_sections($block->id, $this->user->id, $content, $thumbnail);


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}