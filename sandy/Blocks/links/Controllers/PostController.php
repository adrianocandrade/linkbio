<?php

namespace Sandy\Blocks\links\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function create(Request $request){
        $model = new YettiBlock;
        if (!$model->find($request->block_id)) {
            return false;
        }

        $content = [
            'heading' => 'New Link 🤩',
            'link' => 'https://yetti.page',
        ];

        (new \YettiBlocks)->post_blocks_sections($request->block_id, $this->user->id, $content);

        return ['status' => 1, 'response' => (new \YettiBlocks)->fetch_blocks_sections($request->block_id)->toJson()];
    }

    public function post_new_block(Request $request){
        $block = (new \YettiBlocks)->create_block($this->user->id, 'links', $title = 'My New Block');

        
        $request->request->add(['block_id' => $block->id]);
        $this->create($request);


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }
}