<?php

namespace Modules\Mix\Http\Controllers\Blocks;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class CreateController extends Controller{
    public function post($block, Request $request){
        // Check if block exists
        if (!\Blocks::has($block)) {
            abort(404);
        }

        $id = $request->get('block_id');
        
        // Thumbnail
        $thumbnail = sandy_upload_modal_upload($request, 'media/blocks', '2048', $this->user->id);

        // Content
        $content = [];
        if (!empty($request->content)) {
            // Loop our content array

            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        // Blocks
        $blocks = [];
        if (!empty($request->blocks)) {
            // Loop our blocks array
            foreach ($request->blocks as $key => $value) {
                $blocks[$key] = $value;
            }
        }

        // Create Block
        $workspaceId = session('active_workspace_id');
        
        // ✅ Segurança: Validar que workspace da sessão pertence ao usuário
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                // Workspace inválida, usar default
                $workspaceId = null;
            }
        }
        
        if (!$workspaceId) {
            // Fallback: get default workspace
            $defaultWorkspace = \App\Models\Workspace::where('user_id', $this->user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
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

        return redirect()->route("user-mix", ['block' => $wrapper->id])->with('success', __('Saved Successfully'));
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
        $thumbnail = sandy_upload_modal_upload($request, 'media/blocks', '2048', $this->user->id);

        // Content
        $content = [];
        if (!empty($request->content)) {
            // Loop our content array

            foreach ($request->content as $key => $value) {
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


        return redirect()->route("user-mix", ['block' => $wrapper->id])->with('success', __('Block added'));
    }

    public function edit($id, Request $request){
        if (!$blocks = Blockselement::where('id', $id)->where('user', $this->user->id)->first()) {
            abort(404);
        }

        $wrapper = Block::find($blocks->block_id);
        // Thumbnail
        $thumbnail = sandy_upload_modal_upload($request, 'media/blocks', '2048', $this->user->id, $blocks->thumbnail);

        // Content
        $content = [];
        if (!empty($request->content)) {
            // Loop our content array

            foreach ($request->content as $key => $value) {
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
}
