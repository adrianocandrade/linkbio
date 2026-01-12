<?php

namespace Modules\Mix\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Workspace;
use App\Models\Plan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WorkspaceController extends Controller
{
    // Palavras reservadas que não podem ser usadas como slug
    protected $reservedSlugs = [
        'admin', 'api', 'auth', 'mix', 'settings', 'workspace',
        'create', 'edit', 'delete', 'switch', 'store', 'update',
        'index', 'home', 'login', 'register', 'logout', 'dashboard'
    ];

    public function create() {
        $user = Auth::user();
        return view('mix::workspace.create', compact('user'));
    }

    public function store(Request $request) {
        $user = Auth::user();
        
        // Validação melhorada com palavras reservadas
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:workspaces,slug',
                'not_in:' . implode(',', $this->reservedSlugs),
                'regex:/^[a-z0-9-]+$/'
            ],
        ]);

        // Normalizar slug (lowercase)
        $slug = strtolower($request->slug);

        // Transação com lock para evitar race condition
        try {
            DB::beginTransaction();

            // Check Plan Limits com lock para evitar race condition
            $plan = Plan::find($user->plan); 
            
            $limit = 1;
            if ($plan && isset($plan->settings['workspaces_limit'])) {
                $limit = (int) $plan->settings['workspaces_limit'];
            }
            
            // Lock para evitar race condition - contar apenas workspaces ativas
            $workspaceCount = $user->workspaces()
                ->lockForUpdate()
                ->where('status', 1)
                ->count();
            
            if ($workspaceCount >= $limit) {
                DB::rollBack();
                return back()->with('error', __('You have reached the maximum number of workspaces allowed by your plan. Limit: :limit', ['limit' => $limit]));
            }

            // Clone User's default bio settings for consistency
            $defaultWorkspace = $user->workspaces()->where('is_default', 1)->first();
            
            $workspace = new Workspace();
            $workspace->user_id = $user->id;
            $workspace->name = $request->name;
            $workspace->slug = $slug;
            $workspace->status = 1;
            
            // Inherit styling if possible
            if ($defaultWorkspace) {
                 $workspace->theme = $defaultWorkspace->theme;
                 $workspace->font = $defaultWorkspace->font;
            }

            $workspace->save();

            DB::commit();

            // Logging de ação sensível
            Log::info('Workspace created', [
                'user_id' => $user->id,
                'workspace_id' => $workspace->id,
                'workspace_slug' => $workspace->slug,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Switch to new workspace
            session(['active_workspace_id' => $workspace->id]);

            return redirect()->route('user-mix')->with('success', __('Workspace created successfully.'));
            
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Workspace creation failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
                'ip' => $request->ip()
            ]);
            
            return back()->with('error', __('An error occurred while creating the workspace. Please try again.'));
        }
    }

    public function switch($id) {
        // Validar que ID é numérico
        if (!is_numeric($id)) {
            abort(404);
        }

        // Validar propriedade, status e permissão
        $workspace = Workspace::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 1) // ✅ Verificar status ativo
            ->first();

        if (!$workspace) {
            Log::warning('Workspace switch attempt failed', [
                'user_id' => Auth::id(),
                'workspace_id' => $id,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            abort(404, __('Workspace not found or you do not have permission to access it.'));
        }
        
        session(['active_workspace_id' => $workspace->id]);
        
        Log::info('Workspace switched', [
            'user_id' => Auth::id(),
            'workspace_id' => $workspace->id,
            'ip' => request()->ip()
        ]);
        
        return redirect()->back()->with('success', __('Switched to workspace: ') . $workspace->name);
    }

    public function edit($id) {
        // Validar que ID é numérico
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1) // ✅ Verificar status ativo
            ->firstOrFail();
        
        // ✅ Segurança: Workspace principal não pode ter slug editado
        // Isso previne problemas com URLs duplicadas e quebra de rotas públicas
        $isDefault = $workspace->is_default == 1;
            
        return view('mix::workspace.edit', compact('user', 'workspace', 'isDefault'));
    }

    public function update(Request $request, $id) {
        // Validar que ID é numérico
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1) // ✅ Verificar status ativo
            ->firstOrFail();

        // ✅ Segurança: Workspace principal (is_default) não pode ter slug editado
        // Isso previne problemas com URLs duplicadas, quebra de rotas públicas e conflitos
        $isDefault = $workspace->is_default == 1;
        
        // Regras de validação baseadas se é workspace principal
        $validationRules = [
            'name' => 'required|string|max:255',
        ];
        
        // Apenas validar slug se NÃO for workspace principal
        if (!$isDefault) {
            $validationRules['slug'] = [
                'required',
                'string',
                'min:3',
                'max:50',
                'alpha_dash',
                'unique:workspaces,slug,'.$workspace->id,
                'not_in:' . implode(',', $this->reservedSlugs),
                'regex:/^[a-z0-9-]+$/'
            ];
        }

        $request->validate($validationRules);

        $oldSlug = $workspace->slug;
        $workspace->name = $request->name;
        
        // ✅ Segurança: Não permitir alteração de slug da workspace principal
        if (!$isDefault) {
            $workspace->slug = strtolower($request->slug);
        } else {
            // Se tentou alterar slug da workspace principal, ignorar e logar tentativa
            if ($request->slug !== $workspace->slug) {
                Log::warning('Attempt to edit default workspace slug blocked', [
                    'user_id' => $user->id,
                    'workspace_id' => $workspace->id,
                    'attempted_slug' => $request->slug,
                    'current_slug' => $workspace->slug,
                    'ip' => $request->ip()
                ]);
                
                return back()->with('error', __('You cannot change the URL slug of your main workspace. The main workspace URL is permanent and cannot be modified to prevent conflicts and broken links.'));
            }
        }
        
        $workspace->save();

        // Logging de ação sensível
        Log::info('Workspace updated', [
            'user_id' => $user->id,
            'workspace_id' => $workspace->id,
            'old_slug' => $oldSlug,
            'new_slug' => $workspace->slug,
            'is_default' => $isDefault,
            'slug_changed' => !$isDefault && $oldSlug !== $workspace->slug,
            'ip' => $request->ip()
        ]);

        return back()->with('success', __('Workspace updated successfully.'));
    }

    public function delete($id) {
        // Validar que ID é numérico
        if (!is_numeric($id)) {
            abort(404);
        }

        $user = Auth::user();
        $workspace = Workspace::where('id', $id)
            ->where('user_id', $user->id)
            ->where('status', 1) // ✅ Verificar status ativo
            ->firstOrFail();

        // Protect: Cannot delete the first/default workspace
        // Check if it's marked as default OR if it's the first one created
        if ($workspace->is_default == 1) {
            return back()->with('error', __('You cannot delete your main workspace. This workspace is permanently linked to your account.'));
        }
        
        // Double check: if it's the oldest workspace, also protect it
        $firstWorkspace = Workspace::where('user_id', $user->id)
            ->where('status', 1)
            ->orderBy('created_at', 'asc')
            ->first();
        if ($workspace->id === $firstWorkspace->id) {
            return back()->with('error', __('You cannot delete your main workspace. This workspace is permanently linked to your account.'));
        }

        // Backup antes de deletar
        self::processDeletion($workspace);

        // Logging de ação sensível (deleção)
        Log::warning('Workspace deleted', [
            'user_id' => $user->id,
            'workspace_id' => $workspace->id,
            'workspace_slug' => $workspace->slug,
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        // Reset Session if active
        if (session('active_workspace_id') == $id) {
            session()->forget('active_workspace_id');
            // Set active to default workspace or first available (apenas ativas)
            $defaultWorkspace = Workspace::where('user_id', $user->id)
                ->where('is_default', 1)
                ->where('status', 1)
                ->first();
            if ($defaultWorkspace) {
                session(['active_workspace_id' => $defaultWorkspace->id]);
            } else {
                $next = Workspace::where('user_id', $user->id)
                    ->where('status', 1)
                    ->first();
                if ($next) {
                    session(['active_workspace_id' => $next->id]);
                }
            }
        }

        return redirect()->route('user-mix')->with('success', __('Workspace deleted successfully.'));
    }

    public static function processDeletion(Workspace $workspace) {
        // Security / Fraud Prevention Backup
        // We load user relationship to have context on who owned it
        $backupData = $workspace->load('user')->toArray();
        $backupJson = json_encode($backupData, JSON_PRETTY_PRINT);
        
        // Ensure directory exists
        $path = storage_path('app/backups/workspaces');
        if(!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $filename = 'workspace_backup_' . $workspace->id . '_' . time() . '.json';
        file_put_contents($path . '/' . $filename, $backupJson);

        // Delete
        $workspace->delete();
    }
}
