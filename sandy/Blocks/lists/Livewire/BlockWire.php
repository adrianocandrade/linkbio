<?php

namespace Sandy\Blocks\lists\Livewire;

use App\Models\Element;
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
        "thumbnail.*" => 'image|max:2048',
        'blocks.*.content.heading' => 'required',
        'blocks.*.content.subheading' => 'required',
        'blocks.*.content.link' => 'required',

    ];

    
    protected $listeners = ['useElement'];

    public function useElement($data){
        $id = ao($data, 'id');
        $index = ao($data, 'index');
        
        $block_id = ao($data, 'block_id');
        if ($element = Element::find($id)) {
            // This is our element

            if (\Route::has("sandy-app-$element->element-render")) {
                $link = route("sandy-app-$element->element-render", $element->slug);

                if($block_id == $this->block_id){

                    $this->blocks[$index]['content']['link'] = parse($link, 'path');
                }
            }
        }
    }
    
    public function mount(){
        $this->refresh_blocks();
    }

    public function add_new(){
        $yettiblock = new \YettiBlocks;

        $content = [
            'heading' => 'How Crazy Am I?',
            'subheading' => 'Perfect page builder for creatives & get to do more with a linkinbio',
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

        $thumbnail = ao($update->thumbnail, 'upload');
        if(!empty($this->thumbnail)){
            $filesystem = sandy_filesystem('media/blocks');
            
            if (!empty(ao($update->thumbnail, 'upload')) && mediaExists('media/blocks', ao($update->thumbnail, 'upload'))) {
                storageDelete('media/blocks', ao($update->thumbnail, 'upload')); 
            }
            $thumbnail = $this->thumbnail->storePublicly('media/blocks', $filesystem);
            $thumbnail = str_replace('media/blocks', "", $thumbnail);
        }

        $content = [
            'heading' => ao($this->blocks[$index], 'content.heading'),
            'subheading' => ao($this->blocks[$index], 'content.subheading'),
            'link' => ao($this->blocks[$index], 'content.link')
        ];

        $thumbnail = [
            'type' => 'upload',
            'upload' => $thumbnail,
            'link' => ''
        ];
        
        $update->thumbnail = $thumbnail;
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

        return view('Blocks-lists::livewire');
    }
}
