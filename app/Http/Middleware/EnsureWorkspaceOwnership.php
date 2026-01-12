<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Workspace;

class EnsureWorkspaceOwnership
{
    public function handle($request, Closure $next)
    {
        $workspaceId = $request->route('workspace_id') ?? $request->input('workspace_id');
        
        if ($workspaceId) {
            $workspace = Workspace::where('id', $workspaceId)
                ->where('user_id', auth()->id())
                ->first();
            
            if (!$workspace) {
                abort(403, 'Unauthorized workspace access');
            }
            
            $request->attributes->set('workspace', $workspace);
        }
        
        return $next($request);
    }
}
