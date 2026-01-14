<?php

namespace Modules\Bio\Http\Controllers;

use App\Models\Block;
use App\Models\BioApp;
use App\Models\Highlight;
use App\Models\YettiBlock;
use Sandy\Segment\Segments;
use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Modules\Bio\Http\Controllers\Base\Controller;

class BioController extends Controller{
    public function bio(Request $request){
        // Get workspace_id if available, otherwise use user_id
        $workspaceId = $this->workspace->id ?? null;
        $userId = $this->bio->id;
        
        // ✅ Sync session with current workspace if user is authenticated
        if (\Auth::check() && \Auth::user()->id == $userId && $workspaceId) {
            session(['active_workspace_id' => $workspaceId]);
        }
        
        $limit = plan('settings.blocks_limit', $userId);
        $limit = ($limit !== null && !empty($limit)) ? $limit : (int) config('sandy.config.blocks.start_block_upgrade');

        // Query blocks - filter by workspace_id if available, otherwise by user_id
        $blocksQuery = YettiBlock::where('user', $userId);
        if ($workspaceId) {
            $blocksQuery->where('workspace_id', $workspaceId);
        }
        $blocks = $blocksQuery->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')
                ->limit($limit)
                ->get();

        // Query highlights - filter by workspace_id if available
        $highlightsQuery = Highlight::where('user', $userId);
        if ($workspaceId) {
            $highlightsQuery->where('workspace_id', $workspaceId);
        }
        $highlights = $highlightsQuery->get();
        
        $socials = \App\User::ordered_social($userId);

        if (\Auth::check() && \Auth::user()->id == $userId && !$request->get('preview')) {
            $this->mixing_auth = true;
            return view('bio::mix', ['socials' => $socials, 'blocks' => $blocks, 'highlights' => $highlights]);
        }

        return view('bio::bio', [
            'blocks' => $blocks, 
            'highlights' => $highlights,
            'workspace' => $this->workspace
        ]);
    }

    public function dark_mode(Request $request){
        $bio = $this->bio;
        session()->put("bio-dark-$bio->id", $request->dark);
    }
}