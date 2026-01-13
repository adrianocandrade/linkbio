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
        if (!$wrapper = YettiBlock::where('id', $id)
            ->where('user', $this->user->id)
            ->first()) {
            abort(404);
        }

        // Validate workspace context if block belongs to one
        if ($wrapper->workspace_id) {
             $workspace = \App\Models\Workspace::where('id', $wrapper->workspace_id)
                ->where('user_id', $this->user->id)
                ->where('status', 1)
                ->first();
                
             if (!$workspace) {
                 abort(404);
             }
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
