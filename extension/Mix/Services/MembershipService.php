<?php

namespace Modules\Mix\Services;

use Modules\Mix\Models\Membership;
use Modules\Mix\Models\MembershipSubscription;
use Modules\Mix\Models\AudienceContact;

class MembershipService
{
    /**
     * Create a new membership plan
     */
    public function createPlan(array $data)
    {
        return Membership::create($data);
    }
    
    /**
     * Update an existing plan
     */
    public function updatePlan(Membership $membership, array $data)
    {
        $membership->update($data);
        return $membership;
    }
    
    /**
     * Get active plans for a workspace
     */
    public function getActivePlans($workspaceId)
    {
        return Membership::where('workspace_id', $workspaceId)
            ->where('status', 'active')
            ->orderBy('price', 'asc')
            ->get();
    }
    
    /**
     * Subscribe a contact to a membership
     */
    public function subscribeContact($contactId, $membershipId, $paymentMethod = 'manual', $paymentId = null, $startDate = null)
    {
        $contact = AudienceContact::findOrFail($contactId);
        $membership = Membership::findOrFail($membershipId);
        
        // Ensure contact and membership belong to same workspace
        if ($contact->workspace_id != $membership->workspace_id) {
            throw new \Exception('Workspace mismatch between contact and membership');
        }
        
        $start = $startDate ? \Carbon\Carbon::parse($startDate) : now();
        $end = $this->calculateExpirationDate($membership->billing_cycle, $start);
        
        $subscription = MembershipSubscription::create([
            'workspace_id' => $membership->workspace_id,
            'membership_id' => $membershipId,
            'contact_id' => $contactId,
            'payment_status' => 'active',
            'started_at' => $start,
            'expires_at' => $end,
        ]);
        
        return $subscription;
    }
    
    /**
     * Check if contact has active access to membership
     */
    public function hasActiveAccess($contactId, $membershipId)
    {
        $subscription = MembershipSubscription::where('contact_id', $contactId)
            ->where('membership_id', $membershipId)
            ->where('status', 'active')
            ->orderBy('id', 'desc')
            ->first();
            
        if (!$subscription) {
            return false;
        }
        
        return $subscription->isActive();
    }
    
    /**
     * Calculate expiration date based on billing cycle
     */
    private function calculateExpirationDate($billingCycle, $startDate)
    {
        $date = clone $startDate;
        
        switch ($billingCycle) {
            case 'monthly':
                return $date->addMonth();
            case 'yearly':
                return $date->addYear();
            case 'lifetime':
                return null; // Acesso vitalício ou até ser cancelado
            default:
                return $date->addMonth();
        }
    }
}
