<?php

namespace Modules\Mix\Http\Controllers\Highlight;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Highlight;

class EditController extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function edit($id){
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

        return view('mix::highlight.edit', ['highlight' => $highlight]);
    }


    public function editPost($id, Request $request){
        $request->validate([
            'content.heading' => 'required|string',
        ]);
        
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


        // Thumbnail
        $thumbnail = sandy_upload_modal_upload($request, 'media/highlight', '2048', $this->user->id, $highlight->thumbnail);

        // Content
        $content = [];
        if (!empty($request->content)) {
            // Loop our content array

            foreach ($request->content as $key => $value) {
                $content[$key] = $value;
            }
        }

        $highlight->thumbnail = $thumbnail;
        $highlight->link = (string) $this->addscheme($request->link);
        $highlight->content = $content;
        $highlight->is_element = $request->is_element;

        if ($request->is_element) {
            $highlight->element = $request->element;
        }

        $highlight->update();


        return back()->with('success', __('Saved Successfully'));
    }


    public function addscheme($url){
        if (!empty($url)) {
            return addHttps($url);
        }


        return $url;
    }

    private function processImage($request, $input, $highlight_id = null){
        if (empty($request->{$input})) {
            return false;
        }

        // Random image name
        $slug = md5(microtime());

        // Validate image
        $request->validate([
            $input => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($highlight = Highlight::find($highlight_id)) {
            if (!empty(ao($highlight->thumbnail, 'upload')) && mediaExists('media/highlight', ao($highlight->thumbnail, 'upload'))) {
                \UserStorage::remove('media/highlight', ao($highlight->thumbnail, 'upload')); 
            }
        }

        // Image name
        $image = \UserStorage::put('media/highlight', $request->{$input}, $this->user->id);

        // Return image name
        return $image;
    }
}
