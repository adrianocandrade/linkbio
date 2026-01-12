<?php

namespace Modules\Mix\Http\Controllers\Audience;

use Illuminate\Http\Request;
use Modules\Bio\Http\Controllers\Base\Controller;
use Modules\Mix\Services\AudienceService;
use Modules\Mix\Models\AudienceContact;

class AudienceController extends Controller
{
    protected $audienceService;

    public function __construct(AudienceService $audienceService)
    {
        // Se precisar de middleware de auth, ou usar o do pai
        // $this->middleware('auth');
        $this->audienceService = $audienceService;
    }

    public function index(Request $request)
    {
        // Garantir que user tem permissão para este workspace?
        // O Base Controller já deve carregar $this->workspace se estiver no contexto bio
        // Mas o Mix é admin panel.
        // Se for admin panel, o workspace vem da sessão ou da URL admin.
        
        // Pega workspace ativo da sessão (admin context)
        $workspaceId = session('active_workspace_id');
        
        if (!$workspaceId) {
            // Fallback para workspace default do user logado
            $workspaceId = \App\Models\Workspace::where('user_id', auth()->id())
                ->where('is_default', 1)
                ->first()->id;
        }

        $filters = [
            'search' => $request->get('search'),
            'source' => $request->get('source'),
            'status' => $request->get('status'),
        ];

        $contacts = $this->audienceService->getContactsByWorkspace($workspaceId, $filters);
        
        // Stats
        $totalContacts = AudienceContact::where('workspace_id', $workspaceId)->count();
        $totalRevenue = AudienceContact::where('workspace_id', $workspaceId)->sum('total_spent');
        $newThisMonth = AudienceContact::where('workspace_id', $workspaceId)
            ->where('created_at', '>=', now()->startOfMonth())
            ->count();

        $user = auth()->user();
        return view('mix::audience.index', compact('contacts', 'filters', 'totalContacts', 'totalRevenue', 'newThisMonth', 'workspaceId', 'user'));
    }

    public function show($id)
    {
        // Validar ownership
        // Validar ownership e isolamento por workspace
        $workspaceId = session('active_workspace_id');
        
        $contact = AudienceContact::where('id', $id)
            ->where('user_id', auth()->id())
            ->when($workspaceId, function($q) use ($workspaceId) {
                return $q->where('workspace_id', $workspaceId);
            })
            ->with('interactions')
            ->firstOrFail();

        $user = auth()->user();
        return view('mix::audience.show', compact('contact', 'user'));
    }
}
