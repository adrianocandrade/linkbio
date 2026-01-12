<?php

namespace Sandy\Blocks\links\Livewire;

use App\Models\Element;
use Livewire\Component;
use App\Sandy\YettiBlocks;
use Livewire\WithFileUploads;
use App\Models\YettiBlocksSection;

class Links extends Component
{

    use WithFileUploads;
    
    public $block_id;
    public $blocks;
    public $user_id;

    private $me;
    public $thumbnail;

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

    public function hydrate(){
        $this->emit('select2');
    }

    protected $rules = [
        'blocks.*.content.heading' => 'required',
        'blocks.*.content.link' => 'required|string|min:2',
    ];

    public function mount(){

        $this->refresh_blocks();
    }


    public function changed_thumb($id){
        $this->update = YettiBlocksSection::find($id);
    }


    public function clear_thumb(){
        $this->thumbnail = '';
    }
    
    public function updatedThumbnail($key){
        $this->validate([
            'thumbnail' => 'image|max:2048',
        ]);


        $thumbnail = ao($this->update->thumbnail, 'upload');
        if(!empty($this->thumbnail)){
            $filesystem = sandy_filesystem('media/blocks');
            
            if (!empty(ao($this->update->thumbnail, 'upload')) && mediaExists('media/blocks', ao($this->update->thumbnail, 'upload'))) {
                storageDelete('media/blocks', ao($this->update->thumbnail, 'upload')); 
            }
            $thumbnail = $this->thumbnail->storePublicly('media/blocks', $filesystem);
            $thumbnail = str_replace('media/blocks', "", $thumbnail);

            $thumb['type'] = 'upload';
            $thumb['upload'] = $thumbnail;
        }

        $this->update->thumbnail = $thumb;
        $this->update->save();

        $this->refresh_blocks();
    }

    public function add_new(){
        $content = [
            'heading' => 'New Link 🤩',
            'link' => 'https://yetti.page',
        ];
        (new \YettiBlocks)->post_blocks_sections($this->block_id, $this->user_id, $content);

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
        $update = YettiBlocksSection::find($id);
        $update->content = $this->blocks[$index]['content'];
        $update->save();
    }

    public function refresh_blocks(){
        $block = new YettiBlocks;
        $blocks = $block->fetch_blocks_sections($this->block_id)->jsonserialize();
        $this->blocks = $blocks;

        $this->dispatchBrowserEvent('reApplySelect2');
    }

    public function delete_block($id){
        if (!$delete = YettiBlocksSection::where('id', $id)->where('user', $this->user_id)->first()) {
            return false;
        }

        // Check if image exists
        if (!empty(ao($delete->thumbnail, 'upload')) && mediaExists('media/blocks', ao($delete->thumbnail, 'upload'))) {
            storageDelete('media/blocks', ao($delete->thumbnail, 'upload')); 
        }

        // Delete Block
        $delete->delete();
        
        $this->refresh_blocks();
    }
    public function render()
    {

        return view('Blocks-links::livewire');
    }
}
