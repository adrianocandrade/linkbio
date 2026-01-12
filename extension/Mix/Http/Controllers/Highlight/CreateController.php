<?php

namespace Modules\Mix\Http\Controllers\Highlight;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Modules\Mix\Http\Controllers\Base\Controller;
use App\Models\Highlight;

class CreateController extends Controller{
    function __construct(){
        parent::__construct();
    }
    public function create(){


        return view('mix::highlight.create');
    }


    public function createPost(Request $request){
        $request->validate([
            'content.heading' => 'required|string',
        ]);

        // ✅ Segurança: Validar workspace da sessão
        $workspaceId = session('active_workspace_id');
        if ($workspaceId) {
            $workspace = \App\Models\Workspace::where('id', $workspaceId)
                ->where('user_id', auth()->id())
                ->where('status', 1)
                ->first();
            
            if (!$workspace) {
                // Workspace inválida, usar default
                $defaultWorkspace = \App\Models\Workspace::where('user_id', auth()->id())
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
            $defaultWorkspace = \App\Models\Workspace::where('user_id', auth()->id())
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                $workspaceId = $defaultWorkspace->id;
            } else {
                abort(403, __('No valid workspace found.'));
            }
        }

        // Verificar limite por workspace, não global
        if (Highlight::where('user', auth()->id())
            ->where('workspace_id', $workspaceId)
            ->count() >= (int) config('sandy.config.highlight.limit')) {
            return back()->with('error', __('You can only post :num highlight(s).', ['num' => config('sandy.config.highlight.limit')]));
        }

        // Thumbnail
        $thumbnail = sandy_upload_modal_upload($request, 'media/highlight', '2048', auth()->id());;

        // Content
        $content = [];
        $requestContent = $request->input('content', []);
        if (!empty($requestContent)) {
            // Loop our content array

            foreach ($requestContent as $key => $value) {
                $content[$key] = $value;
            }
        }

        $highlight = new Highlight;
        $highlight->user = auth()->id();
        $highlight->workspace_id = $workspaceId;
        $highlight->thumbnail = $thumbnail;
        $highlight->link = (string) $this->addscheme($request->input('link'));
        $highlight->content = $content;
        $highlight->is_element = $request->input('is_element');

        if ($request->input('is_element')) {
            $highlight->element = $request->input('element');
        }

        $highlight->save();


        return redirect()->route('user-mix')->with('success', __('Saved Successfully'));
    }


    public function addscheme($url){
        if (!empty($url)) {
            return addHttps($url);
        }


        return $url;
    }
}
