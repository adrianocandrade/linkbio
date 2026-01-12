<?php

namespace Sandy\Blocks\embed\Livewire;

use Livewire\Component;
use App\Sandy\YettiBlocks;
use App\Models\YettiBlocksSection;

class BlockWire extends Component
{

    public $block_id;
    public $blocks;
    public $user_id;

    protected $rules = [

        'blocks.*.content.name' => 'required',
        'blocks.*.content.link' => 'required|string|min:2',

    ];

    public function mount(){

        $this->refresh_blocks();
    }

    public function add_new(){
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

        $yettiblock->post_blocks_sections($this->block_id, $this->user_id, $blocks);

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

    public function edit($id, $index){
        //$content = [
        //    'name' => $request->name,
        //    'link' => $request->link
        //];
        $yettiblock = new \YettiBlocks;

        $link = addHttps($this->blocks[$index]['content']['link']);
        $fetch = [];
        $blocks = ['link' => $link];

        $fetch = (new \App\Sandy\SandyEmbed($link))->fetch();

        $blocks['fetch'] = $fetch;

        $update = YettiBlocksSection::find($id);
        $update->content = $blocks;
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

        return view('Blocks-embed::livewire');
    }
}
