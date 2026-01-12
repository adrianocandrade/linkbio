<?php

namespace Sandy\Blocks\course\Controllers;

use App\Models\Block;
use App\Models\YettiBlock;
use Illuminate\Http\Request;
use App\Models\Blockselement;
use App\Models\YettiBlocksSection;
use Illuminate\Contracts\Support\Renderable;
use Modules\Mix\Http\Controllers\Base\Controller;

class DeleteController extends Controller{
    public $name = 'course';

    public function deleteItem(Request $request){
        
        // Check if block element exits
        if (!$delete = YettiBlocksSection::where('id', $request->id)->first()) {
            return false;
        }

        // Check if image exists
        if (!empty(ao($delete->thumbnail, 'upload')) && mediaExists('media/blocks', ao($delete->thumbnail, 'upload'))) {
            storageDelete('media/blocks', ao($delete->thumbnail, 'upload')); 
        }

        // Delete Block
        $delete->delete();
    }
    
    public function delete($id, Request $request){
        $delete = YettiBlock::find($id);

        // Check if block element exits
        if (!$delete) {
            abort(404);
        }

        $elem = YettiBlocksSection::where('block_id', $delete->id)->get();
        foreach ($elem as $value) {
            $request->request->add(['id' => $value->id]);
            
            $this->deleteItem($request);
        }

        // Delete Block
        $delete->delete();
        return back()->with('success', __('Deleted Successfully'));
    }
}