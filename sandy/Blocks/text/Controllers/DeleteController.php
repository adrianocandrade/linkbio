<?php

namespace Sandy\Blocks\text\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Block;
use App\Models\Blockselement;

class DeleteController extends Controller{
    public $name = 'text';

    public function deleteItem(Request $request){
        $delete = Blockselement::find($request->id);


        // Check if block element exits
        if (!$delete) {
            abort(404);
        }

        // Check if block belongs to user
        $block = Block::where('id', $delete->block_id)->where('user', $this->user->id)->first();
        if (!$block) {
            abort(404);
        }

        // Delete Block
        $delete->delete();
        return back()->with('success', __('Deleted Successfully'));
    }

    public function delete($id, Request $request){
        $delete = Block::find($id);

        // Check if block element exits
        if (!$delete) {
            abort(404);
        }

        $elem = Blockselement::where('block_id', $delete->id)->get();
        foreach ($elem as $value) {
            $request->request->add(['id' => $value->id]);
            
            $this->deleteItem($request);
        }

        // Delete Block
        $delete->delete();
        return back()->with('success', __('Deleted Successfully'));
    }
}