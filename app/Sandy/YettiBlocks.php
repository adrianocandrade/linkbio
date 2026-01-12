<?php

namespace App\Sandy;

use App\Models\YettiBlock;
use App\Models\YettiBlocksSection;

class YettiBlocks{

    public function get_blocks($block_id){
        $model = new YettiBlock;

        $block = $model->find($block_id);

        
        $sections = YettiBlocksSection::where('block_id', $block->id)
        ->orderBy('position', 'ASC')
        ->orderBy('id', 'DESC')
        ->get();
        
        if (!$block) {
            return false;
        }

        // Check if block exists
        if (is_dir($path = base_path("sandy/Blocks/$block->block/Block"))) {
            $blockFolder = new \DirectoryIterator($path);

            if (file_exists($include = "$path/views.php")) {
                require $include;
            }
        }

    }

    public function create_route($block){
        $route = "sandy-blocks-$block-create-block";

        if (\Route::has($route)) {

            return route($route);
        }

        $route = config("blocks.$block.route");
        if ($route && \Route::has($route)) {

            return route($route);
        }

        return '#';
    }
    public function get_edit_blocks($block_id){
        $model = new YettiBlock;
        $sections = new YettiBlocksSection;

        $block = $model->find($block_id);
        $block['sections'] = $sections->where('block_id', $block->id)
                            ->orderBy('position', 'ASC')
                            ->orderBy('id', 'DESC')
                            ->get();

        if (!$block) {
            return false;
        }

        // Check if block exists
        if (is_dir($path = base_path("sandy/Blocks/$block->block/Block"))) {
            $blockFolder = new \DirectoryIterator($path);
            if(view()->exists("Blocks-$block->block::mixing")){
                return view("Blocks-$block->block::mixing", ['block' => $block]);
            }
        }
    }


    public function fetch_blocks_sections($block_id){
        $sections = new YettiBlocksSection;
        return $sections->where('block_id', $block_id)
        ->orderBy('position', 'ASC')
        ->orderBy('id', 'DESC')
        ->get();
    }


    public function post_blocks_sections($block_id, $user_id, $content, $thumbnail = []){
        $sections = new YettiBlocksSection;
        $sections->block_id = $block_id;
        $sections->thumbnail = $thumbnail;
        $sections->user = $user_id;
        $sections->content = $content;
        $sections->save();

        return true;
    }


    public function edit_blocks_sections($section_id, $content){
        if (!$section = YettiBlocksSection::find($section_id)) {
            return false;
        }
        $section->content = $content;
        $section->save();

        return $section;
    }


    public function create_block($user, $block_name, $title = 'Dummy Block', $blocks = []){

        $blocks['heading'] = $title;

        // Get workspace_id from session if available
        $workspaceId = session('active_workspace_id', null);
        
        // ✅ Segurança: Validar que workspace da sessão pertence ao usuário
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $user)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                // Workspace inválida, usar default
                $workspaceId = null;
            }
        }
        
        if (!$workspaceId) {
            // Fallback: get default workspace for user
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $user)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
            }
        }

        $block = new YettiBlock;
        $block->user = $user;
        $block->workspace_id = $workspaceId;
        $block->block = $block_name;
        $block->title = $title;
        $block->blocks = $blocks;
        $block->save();


        return $block;
    }
}
