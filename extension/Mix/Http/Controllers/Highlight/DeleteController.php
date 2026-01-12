<?php

namespace Modules\Mix\Http\Controllers\Highlight;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Highlight;

class DeleteController extends Controller{
    public function delete($id){
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
        
        if (!$highlight = Highlight::where('id', $id)
            ->where('user', $this->user->id)
            ->where('workspace_id', $workspaceId)
            ->first()) {
            abort(404);
        }

        // Remove Image
        if (!empty(ao($highlight->thumbnail, 'upload')) && mediaExists('media/highlight', ao($highlight->thumbnail, 'upload'))) {
            \UserStorage::remove('media/highlight', ao($highlight->thumbnail, 'upload')); 
        }

        $highlight->delete();

        return redirect()->route('user-mix')->with('success', __('Highlight removed.'));
    }
}
