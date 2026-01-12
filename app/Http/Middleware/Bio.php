<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Domain as Userdomain;
use App\Models\Workspace;

class Bio
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next){
        $domain = $request->getHost();
        $bioSlug = $request->bio ?? null;

        // Check for custom domain first
        if ($domainModel = Userdomain::where('host', $domain)->first()) {
            // If domain has workspace_id, use it
            if (isset($domainModel->workspace_id) && $domainModel->workspace_id) {
                if ($workspace = Workspace::where('id', $domainModel->workspace_id)
                    ->where('status', 1)
                    ->first()) {
                    $request->merge(['bio' => $workspace->slug]);
                    return $next($request);
                }
            }
            
            // Fallback: domain linked to user (backward compatibility)
            if ($user = \App\User::find($domainModel->user)) {
                // Get default workspace for this user
                $defaultWorkspace = Workspace::where('user_id', $user->id)
                    ->where('is_default', 1)
                    ->where('status', 1)
                    ->first();
                
                if ($defaultWorkspace) {
                    $request->merge(['bio' => $defaultWorkspace->slug]);
                } else {
                    // Fallback to username for backward compatibility
                    $request->merge(['bio' => $user->username]);
                }
            }
        }

        // If bio slug is provided, try to find workspace first, then fallback to username
        if ($bioSlug) {
            $workspace = Workspace::where('slug', $bioSlug)
                ->where('status', 1)
                ->first();
            
            if ($workspace) {
                // Workspace found, use it
                $request->merge(['bio' => $workspace->slug]);
            } else {
                // Fallback: try to find user by username for backward compatibility
                // This allows old URLs with username to still work
                if (\App\User::where('username', $bioSlug)->exists()) {
                    $request->merge(['bio' => $bioSlug]);
                }
            }
        }

        return $next($request);
    }
}
