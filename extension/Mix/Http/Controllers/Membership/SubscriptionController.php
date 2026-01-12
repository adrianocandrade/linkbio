<?php

namespace Modules\Mix\Http\Controllers\Membership;

use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Modules\Mix\Services\MembershipService;
use Modules\Mix\Models\Membership;
use Modules\Mix\Models\MembershipSubscription;

class SubscriptionController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function index($membershipId)
    {
        $workspaceId = session('active_workspace_id');
        
        $membership = Membership::where('id', $membershipId)
            ->where('workspace_id', $workspaceId)
            ->firstOrFail();
            
        $subscriptions = $membership->subscribers()
            ->with('contact')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $user = auth()->user();
        
        return view('mix::membership.subscribers', compact('membership', 'subscriptions', 'user'));
    }
    
    public function create($membershipId)
    {
         // Logic to manually assign subscription (optional for now, but good to have)
         // For now, let's just show the list
    }
}
