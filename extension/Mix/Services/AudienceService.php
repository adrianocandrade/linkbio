<?php

namespace Modules\Mix\Services;

use Modules\Mix\Models\AudienceContact;
use Modules\Mix\Models\AudienceInteraction;

class AudienceService
{
    /**
     * Create or update a contact in the audience list
     */
    public function createOrUpdateContact(array $data)
    {
        $contact = AudienceContact::updateOrCreate(
            [
                'email' => $data['email'],
                'workspace_id' => $data['workspace_id'],
            ],
            [
                'user_id' => $data['user_id'],
                'name' => $data['name'],
                'phone' => $data['phone'] ?? null,
                'avatar' => $data['avatar'] ?? null,
                'source' => $data['source'],
                'source_id' => $data['source_id'] ?? null,
                'metadata' => $data['metadata'] ?? [],
                'tags' => $data['tags'] ?? [],
            ]
        );
        
        // Ensure status is active
        if ($contact->status === 'inactive') {
            $contact->update(['status' => 'active']);
        }
        
        return $contact;
    }
    
    /**
     * Record an interaction for a contact
     */
    public function recordInteraction($contactId, $type, $action, $amount = 0, $metadata = [])
    {
        $contact = AudienceContact::findOrFail($contactId);
        
        AudienceInteraction::create([
            'contact_id' => $contactId,
            'workspace_id' => $contact->workspace_id,
            'type' => $type,
            'action' => $action,
            'amount' => $amount,
            'metadata' => $metadata,
        ]);
        
        // Update contact stats
        $contact->increment('total_interactions');
        $contact->update(['last_interaction_at' => now()]);
        
        // Update total spent if interaction involves money
        if ($amount > 0) {
            $contact->increment('total_spent', $amount);
        }
        
        return true;
    }
    
    /**
     * Get paginated contacts for a workspace with filters
     */
    public function getContactsByWorkspace($workspaceId, $filters = [])
    {
        $query = AudienceContact::where('workspace_id', $workspaceId);
        
        if (isset($filters['source']) && !empty($filters['source'])) {
            $query->where('source', $filters['source']);
        }
        
        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        
        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        
        return $query->orderBy('last_interaction_at', 'desc')
                    ->orderBy('created_at', 'desc')
                    ->paginate(50);
    }
}
