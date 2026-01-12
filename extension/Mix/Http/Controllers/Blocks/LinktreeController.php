<?php

namespace Modules\Mix\Http\Controllers\Blocks;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class LinktreeController extends Controller{
    public function copy(Request $request){
        if (!\Blocks::linktree_links($this->user->id, $request->username)) {
            return back()->with('error', __('Could not import link or page not found.'));
        }

        return back()->with('success', __('Imported Successfully.'));
    }
}
