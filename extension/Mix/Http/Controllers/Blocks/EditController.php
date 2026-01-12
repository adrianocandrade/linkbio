<?php

namespace Modules\Mix\Http\Controllers\Blocks;

use App\Models\Block;
use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\Blockselement;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class EditController extends Controller{
    public function editBlock($id, Request $request){
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
        
        if (!$wrapper = YettiBlock::where('id', $id)
            ->where('user', $this->user->id)
            ->where('workspace_id', $workspaceId)
            ->first()) {
            abort(404);
        }


        // Blocks
        $blocks = $wrapper->blocks;
        if (!empty($request->blocks)) {
            // Loop our blocks array
            foreach ($request->blocks as $key => $value) {
                $blocks[$key] = $value;
            }
        }

        $wrapper->blocks = $blocks;
        $wrapper->update();

        return back()->with('success', __('Saved Successfully'));
    }
}
