<?php

namespace Modules\Mix\Http\Controllers\Membership;

use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Modules\Mix\Services\MembershipService;
use Modules\Mix\Models\Membership;

class MembershipController extends Controller
{
    protected $membershipService;

    public function __construct(MembershipService $membershipService)
    {
        $this->membershipService = $membershipService;
    }

    public function index()
    {
        $workspaceId = session('active_workspace_id');
        
        $plans = Membership::where('workspace_id', $workspaceId)
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        $user = auth()->user();
        
        return view('mix::membership.index', compact('plans', 'user'));
    }

    public function create()
    {
        $user = auth()->user();
        return view('mix::membership.create', compact('user'));
    }

    public function store(Request $request)
    {
        $workspaceId = session('active_workspace_id');
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
        ]);
        
        $data = array_merge($validated, [
            'user_id' => auth()->id(),
            'workspace_id' => $workspaceId,
            'status' => 'active'
        ]);
        
        $this->membershipService->createPlan($data);
        
        return redirect()->route('user-mix-membership-index')
            ->with('success', __('Plan created successfully!'));
    }

    public function edit($id)
    {
        $workspaceId = session('active_workspace_id');
        $plan = Membership::where('id', $id)
            ->where('workspace_id', $workspaceId)
            ->firstOrFail();
            
        $user = auth()->user();
        return view('mix::membership.edit', compact('plan', 'user'));
    }

    public function update(Request $request, $id)
    {
        $workspaceId = session('active_workspace_id');
        $plan = Membership::where('id', $id)
            ->where('workspace_id', $workspaceId)
            ->firstOrFail();
            
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'billing_cycle' => 'required|in:monthly,yearly,lifetime',
            'status' => 'required|in:active,archived',
        ]);
        
        $this->membershipService->updatePlan($plan, $validated);
        
        return redirect()->route('user-mix-membership-index')
            ->with('success', __('Plan updated successfully!'));
    }
    
    public function destroy($id)
    {
        $workspaceId = session('active_workspace_id');
        $plan = Membership::where('id', $id)
            ->where('workspace_id', $workspaceId)
            ->firstOrFail();
            
        $plan->delete();
        
        return redirect()->route('user-mix-membership-index')
            ->with('success', __('Plan deleted successfully!'));
    }
}
