<?php

namespace Sandy\Blocks\video\Livewire;

use Livewire\Component;
use App\Sandy\YettiBlocks;
use App\Models\YettiBlocksSection;

class BlockWire extends Component
{

    public $block_id;
    public $blocks;
    public $user_id;

    public $skeleton;

    protected $rules = [

        'blocks.*.content.link' => 'required',
        'blocks.*.content.type' => 'required',

    ];

    public function mount(){
        $this->skeleton = getOtherResourceFile('videoType', 'bio');

        $this->refresh_blocks();
    }

    public function add_new(){
        $yettiblock = new \YettiBlocks;

        $link = 'https://youtu.be/lJp6BezFLCk';
        $type = 'youtube';
        $content = [
            'type' => $type,
            'link' => $link,
            'thumbnail' => getVideoBlocksThumbnail($type, $link),
            'isIframe' => $this->is_iframe($type)
        ];

        $yettiblock->post_blocks_sections($this->block_id, $this->user_id, $content);

        $this->refresh_blocks();
    }

    
    private function is_iframe($stream){
        $skeleton = getOtherResourceFile('videoType', 'bio');

        return ao($skeleton, "$stream.isIframe");
    }

    public function sort($list){

        foreach ($list as $key => $value) {
            
            $value['value'] = (int) $value['value'];
            $value['order'] = (int) $value['order'];
            $update = YettiBlocksSection::find($value['value']);
            $update->position = $value['order'];
            $update->save();
        }
        
        $this->refresh_blocks();
    }

    public function edit($id, $index){
        $link = ao($this->blocks[$index], 'content.link');
        $type = ao($this->blocks[$index], 'content.type');
        $content = [
            'type' => $type,
            'link' => $link,
            'thumbnail' => getVideoBlocksThumbnail($type, $link),
            'isIframe' => $this->is_iframe($type)
        ];

        $update = YettiBlocksSection::find($id);
        $update->content = $content;
        $update->save();

        $this->refresh_blocks();
    }

    public function refresh_blocks(){
        $block = new YettiBlocks;
        $blocks = $block->fetch_blocks_sections($this->block_id)->jsonserialize();
        $this->blocks = $blocks;
    }

    public function delete_block($id){
        if (!$delete = YettiBlocksSection::where('id', $id)->where('user', $this->user_id)->first()) {
            return false;
        }

        // Delete Block
        $delete->delete();
        
        $this->refresh_blocks();
    }
    public function render()
    {

        return view('Blocks-video::livewire');
    }
}
