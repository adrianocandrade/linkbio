<?php

namespace Sandy\Blocks\embed\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function create($block_id, $blocks = []){
        $model = new YettiBlock;
        if (!$model->find($request->block_id)) {
            return false;
        }

        $content = [
            'name' => 'New Link 🤩',
            'link' => 'https://yetti.page',
        ];


        return ['status' => 1, 'response' => (new \YettiBlocks)->fetch_blocks_sections($request->block_id)->toJson()];
    }

    public function post_new_block(Request $request){
        $yettiblock = new \YettiBlocks;

        $link = config('app.url');
        $fetch = [];
        $blocks = ['link' => $link];

        try {
            $fetch = (new \App\Sandy\SandyEmbed($link))->fetch();

            $blocks['fetch'] = $fetch;
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }

        $block = $yettiblock->create_block($this->user->id, 'embed', 'My New Embed Link');
        $yettiblock->post_blocks_sections($block->id, $this->user->id, $blocks);


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}