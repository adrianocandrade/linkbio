<?php

namespace App\Traits;

use App\Models\Workspace;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToWorkspace
{
    public function workspace()
    {
        return $this->belongsTo(Workspace::class);
    }
    
    public function scopeForWorkspace(Builder $query, $workspaceId)
    {
        return $query->where('workspace_id', $workspaceId);
    }
    
    public function scopeForCurrentWorkspace(Builder $query)
    {
        $workspaceId = request()->attributes->get('workspace')?->id;
        return $workspaceId ? $query->where('workspace_id', $workspaceId) : $query;
    }
}
