<?php

namespace Modules\Mix\Http\Controllers\Blocks;

use App\Models\Block;
use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\Blockselement;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class BlockController extends Controller{
    public function blocks(){
        $apps = getAllBioApps();
        return view('mix::blocks.blocks', ['apps' => $apps]);
    }

    public function sort(Request $request){
     foreach($request->data as $key) {
        $key['id'] = (int) $key['id'];
        $key['position'] = (int) $key['position'];
        $update = YettiBlock::find($key['id']);
        $update->position = $key['position'];
        $update->save();
     }
    }


    public function edit_block_get($id){
        // Find block by ID and User
        $block = YettiBlock::where('user', $this->user->id)
            ->where('id', $id)
            ->first();

        if (!$block) {
            abort(404);
        }

        // Validate workspace context if block belongs to one
        if ($block->workspace_id) {
             $workspace = \App\Models\Workspace::where('id', $block->workspace_id)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
                
             if (!$workspace) {
                 abort(404);
             }
        }

        return view('mix::blocks.edit-block', ['block' => $block]);
    }

    public function post($block, Request $request){
        // Check if block exists
        if (!\Blocks::has($block)) {
            abort(404);
        }

        $id = $request->get('block_id');
        
        // Thumbnail
        $thumbnail = [
            'type' => $request->sandy_upload_media_type,
            'upload' => $this->processImage($request, 'sandy_upload_media_upload'),
            'link' => $request->sandy_upload_media_link
        ];

        // Content
        $content = [];
        if (!empty($request->input('content'))) {
            // Loop our content array

            foreach ($request->input('content') as $key => $value) {
                $content[$key] = $value;
            }
        }

        // Blocks
        $blocks = [];
        if (!empty($request->input('blocks'))) {
            // Loop our blocks array
            foreach ($request->input('blocks') as $key => $value) {
                $blocks[$key] = $value;
            }
        }

        // Create Block
        $workspaceId = session('active_workspace_id');
        
        // ✅ Segurança: Validar workspace da sessão
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                // Workspace inválida, usar default
                $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                    ->where('is_default', 1)
                    ->where('status', 1)
                    ->first();
                if ($defaultWorkspace) {
                    $workspaceId = $defaultWorkspace->id;
                } else {
                    abort(403, __('No valid workspace found.'));
                }
            }
        } else {
            // Fallback: get default workspace
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
            } else {
                abort(403, __('No valid workspace found.'));
            }
        }

        $wrapper = new Block;
        $wrapper->user = $this->user->id;
        $wrapper->workspace_id = $workspaceId;
        $wrapper->block = $block;
        $wrapper->blocks = $blocks;
        $wrapper->save();


        // Elements
        $blocks = new Blockselement;
        $blocks->block_id = $wrapper->id;
        $blocks->user = $this->user->id;
        $blocks->thumbnail = $thumbnail;
        $blocks->link = $this->https_link($request->link);
        $blocks->content = $content;
        $blocks->is_element = $request->is_element;

        if ($request->is_element) {
            $blocks->element = $request->element;
        }

        $blocks->save();
        return redirect()->route("user-mix")->with('success', __('Saved Successfully'));
    }


    public function newElement($id, Request $request){
        $workspaceId = session('active_workspace_id');
        
        // ✅ Segurança: Validar workspace da sessão
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                abort(404);
            }
        } else {
            abort(404);
        }
        
        if (!$wrapper = Block::where('id', $id)
            ->where('user', $this->user->id)
            ->where('workspace_id', $workspaceId)
            ->first()) {
            abort(404);
        }

        // Thumbnail
        $thumbnail = [
            'type' => $request->sandy_upload_media_type,
            'upload' => null, 
            'link' => $request->sandy_upload_media_link
        ];

        if ($image = $this->processImage($request, 'sandy_upload_media_upload', $id)) {
            $thumbnail['upload'] = $image;
        }

        // Content
        $content = [];
        if (!empty($request->input('content'))) {
            // Loop our content array

            foreach ($request->input('content') as $key => $value) {
                $content[$key] = $value;
            }
        }



        // Elements
        $blocks = new Blockselement;
        $blocks->block_id = $wrapper->id;
        $blocks->user = $this->user->id;
        $blocks->thumbnail = $thumbnail;
        $blocks->link = $this->https_link($request->link);
        $blocks->content = $content;
        $blocks->is_element = $request->is_element;

        if ($request->is_element) {
            $blocks->element = $request->element;
        }

        $blocks->save();


        return redirect()->route("user-mix")->with('success', __('Saved Successfully'));
    }

    public function edit($id, Request $request){
        if (!$blocks = Blockselement::where('id', $id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $wrapper = Block::find($blocks->block_id);
        
        // ✅ Segurança: Validar workspace da sessão e do block
        $workspaceId = session('active_workspace_id');
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace || $wrapper->workspace_id != $workspaceId) {
                abort(404);
            }
        } else {
            abort(404);
        }
        // Thumbnail
        $thumbnail = [
            'type' => $request->sandy_upload_media_type,
            'upload' => ao($blocks->thumbnail, 'upload'), 
            'link' => $request->sandy_upload_media_link
        ];

        if ($image = $this->processImage($request, 'sandy_upload_media_upload', $id)) {
            $thumbnail['upload'] = $image;
        }

        // Content
        $content = [];
        if (!empty($request->input('content'))) {
            // Loop our content array

            foreach ($request->input('content') as $key => $value) {
                $content[$key] = $value;
            }
        }



        // Elements
        $blocks->thumbnail = $thumbnail;
        $blocks->link = $this->https_link($request->link);
        $blocks->content = $content;
        $blocks->is_element = $request->is_element;

        if ($request->is_element) {
            $blocks->element = $request->element;
        }

        $blocks->update();


        return redirect()->route("user-mix", ['block' => $wrapper->id])->with('success', __('Saved Successfully'));
    }

    private function https_link($link){
        if (!empty($link)) {
            return addHttps($link);
        }


        return $link;
    }

    private function processImage($request, $input, $block_id = null){
        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($block = Blockselement::find($block_id)) {
            if (!empty($block->thumbnail) && mediaExists('media/blocks', ao($block->thumbnail, 'upload'))) {
                \UserStorage::remove('media/blocks', ao($block->thumbnail, 'upload')); 
            }
        }

        // Image name
        $image = \UserStorage::put('media/blocks', $request->{$input}, $this->user->id);

        // Return image name
        return $image;
    }
}
