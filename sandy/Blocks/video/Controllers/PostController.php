<?php

namespace Sandy\Blocks\video\Controllers;

use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class PostController extends Controller{
    public function post_new_block(Request $request){
        $yettiblock = new \YettiBlocks;

        $link = 'https://youtu.be/lJp6BezFLCk';
        $type = 'youtube';
        $content = [
            'type' => $type,
            'link' => $link,
            'thumbnail' => getVideoBlocksThumbnail($type, $link),
            'isIframe' => $this->is_iframe($type)
        ];


        $block = $yettiblock->create_block($this->user->id, 'video', 'My New Video');
        $yettiblock->post_blocks_sections($block->id, $this->user->id, $content);


        return redirect()->to(url()->previous() . "#block-id-$block->id")->with('success', __('Block created successfully'));
    }

    private function is_iframe($stream){
        $skeleton = getOtherResourceFile('videoType', 'bio');

        return ao($skeleton, "$stream.isIframe");
    }
}