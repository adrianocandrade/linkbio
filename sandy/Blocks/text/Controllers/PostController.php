<?php

namespace Sandy\Blocks\text\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function post_new_block(Request $request){

        $yettiblock = new \YettiBlocks;
        $blocks = [
            'content' => '<ul><li><p>We have added some blocks to help you get started.</p></li></ul><ul><li><p>Click this to edit or any of the elements below.</p></li></ul><ul><li><p>You can drag them to reorder their position.</p></li></ul><ul><li><p>Click on the (+) icon to add more blocks.</p></li></ul><ul><li><p>Click on the blot menu to add elements.</p></li></ul><ul><li><p>Elements can be in the form of email collection, paid items, etc.</p></li></ul>'
        ];
        $block = $yettiblock->create_block($this->user->id, 'text', 'Welcome Aboard! 🎉', $blocks);


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}