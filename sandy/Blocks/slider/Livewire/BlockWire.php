<?php

namespace Sandy\Blocks\slider\Livewire;

use Livewire\Component;
use App\Sandy\YettiBlocks;
use Livewire\WithFileUploads;
use App\Models\YettiBlocksSection;

class BlockWire extends Component
{
    use WithFileUploads;

    public $block_id;
    public $blocks;
    public $thumbnail;
    public $user_id;

    protected $rules = [
        'blocks.*.content.heading' => 'required',
    ];

    public function mount(){
        $this->refresh_blocks();
    }

    public function add_new(){
        $yettiblock = new \YettiBlocks;

        $content = [
            'heading' => 'Slides are awesome. 🔥',
        ];

        $thumbnail = [
            'type' => 'external',
            'upload' => null,
            'link' => random_avatar(\Str::random(5), 'adventurer-neutral')
        ];

        $yettiblock->post_blocks_sections($this->block_id, $this->user_id, $content, $thumbnail);

        $this->refresh_blocks();
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

    public function clear_thumb(){
        $this->thumbnail = '';
    }


    public function edit($id, $index){
        $update = YettiBlocksSection::find($id);
        $this->validate([
            "thumbnail" => 'image|max:2048',
        ]);
        
        $filesystem = sandy_filesystem('media/blocks');
        $thumb = $update->thumbnail;
        
        $thumbnail = ao($update->thumbnail, 'upload');
        if(!empty($this->thumbnail)){
            $filesystem = sandy_filesystem('media/blocks');
            
            if (!empty(ao($update->thumbnail, 'upload')) && mediaExists('media/blocks', ao($update->thumbnail, 'upload'))) {
                storageDelete('media/blocks', ao($update->thumbnail, 'upload')); 
            }
            $thumbnail = $this->thumbnail->storePublicly('media/blocks', $filesystem);
            $thumbnail = str_replace('media/blocks', "", $thumbnail);

            $thumb['type'] = 'upload';
            $thumb['upload'] = $thumbnail;
        }


        $content = [
            'heading' => ao($this->blocks[$index], 'content.heading'),
        ];

        $update->thumbnail = $thumb;
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

            
        if (!empty(ao($delete->thumbnail, 'upload')) && mediaExists('media/blocks', ao($delete->thumbnail, 'upload'))) {
            storageDelete('media/blocks', ao($delete->thumbnail, 'upload')); 
        }
        // Delete Block
        $delete->delete();
        
        $this->refresh_blocks();
    }
    public function render()
    {

        return view('Blocks-slider::livewire');
    }
}
