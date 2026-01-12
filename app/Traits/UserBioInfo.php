<?php

namespace App\Traits;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Models\MySession;
use App\User;
use App\Models\Workspace;

trait UserBioInfo {
    public $bio;
    public $workspace;

    public function __construct(){
        $this->middleware(function ($request, $next) {
           $bioSlug = $request->bio ?? $request->route('bio') ?? $request->slug ?? $request->route('slug');
           
           // Handle Route Model Binding or Object
           if (is_object($bioSlug)) {
               $bioSlug = $bioSlug->slug ?? $bioSlug->username ?? null;
           }
           
           // Try to find workspace by slug first
           $workspace = Workspace::where('slug', $bioSlug)
               ->where('status', 1)
               ->with('user')
               ->first();
           
           if ($workspace) {
               // Workspace found - use workspace data
               $this->workspace = $workspace;
               $this->bio = $workspace->user;
               
               // Merge workspace attributes into bio for backward compatibility
               // This allows views to access workspace data via $bio
               $workspaceAttributes = $workspace->toArray();
               
               // Map workspace slug to username for compatibility
               if (isset($workspaceAttributes['slug'])) {
                   $this->bio->username = $workspaceAttributes['slug'];
               }
               
               // Override user attributes with workspace attributes where applicable
               foreach ($workspaceAttributes as $key => $value) {
                   if (!in_array($key, ['id', 'user_id', 'created_at', 'updated_at']) && $value !== null) {
                       $this->bio->{$key} = $value;
                   }
               }
               
               MySession::updateBio($this->bio->id);
           } else {
               // Fallback: try to find user by username (backward compatibility)
               if (!$this->bio = User::where('username', $bioSlug)->first()) {
                   abort(404);
               }
               
               // Try to get default workspace for this user
               $defaultWorkspace = Workspace::where('user_id', $this->bio->id)
                   ->where('is_default', 1)
                   ->where('status', 1)
                   ->first();
               
               if ($defaultWorkspace) {
                   $this->workspace = $defaultWorkspace;
               }
               
               MySession::updateBio($this->bio->id);
           }

           return $next($request);
        });


        View::composer('*', function ($view){
            $bio = $this->bio;
            $workspace = $this->workspace ?? null;
            $socials = socials();
            
            View::share('bio', $bio);
            View::share('workspace', $workspace);
            View::share('socials', $socials);
            View::share('sandy', $this);
        });
    }

    
}