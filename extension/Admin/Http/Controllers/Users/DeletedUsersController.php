<?php

namespace Modules\Admin\Http\Controllers\Users;

use Illuminate\Http\Request;
use Modules\Admin\Http\Controllers\Base\Controller;
use App\Services\UserBackupService;
use App\Models\UserBackup;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DeletedUsersController extends Controller
{
    public function index(Request $request)
    {
        $query = UserBackup::query();

        // Filtros
        if ($request->filled('search')) {
            $search = $request->get('search');
            $searchBy = $request->get('search_by', 'email');
            
            if (in_array($searchBy, ['email', 'username', 'name'])) {
                $query->where($searchBy, 'LIKE', "%{$search}%");
            } else {
                // Se não especificado, busca em todos os campos
                $query->where(function($q) use ($search) {
                    $q->where('email', 'LIKE', "%{$search}%")
                      ->orWhere('username', 'LIKE', "%{$search}%")
                      ->orWhere('name', 'LIKE', "%{$search}%");
                });
            }
        }

        // Filtro por status
        if ($request->filled('status')) {
            $status = $request->get('status');
            if ($status === 'restored') {
                $query->where('is_restored', true);
            } elseif ($status === 'active') {
                $query->where('is_restored', false)->where('expires_at', '>', Carbon::now());
            } elseif ($status === 'expired') {
                $query->where('expires_at', '<', Carbon::now());
            }
        }

        // Ordenação
        $orderBy = $request->get('order_by', 'backup_date');
        $orderType = $request->get('order_type', 'DESC');
        
        if (!in_array($orderType, ['ASC', 'DESC'])) {
            $orderType = 'DESC';
        }
        
        if (in_array($orderBy, ['backup_date', 'expires_at', 'email', 'username'])) {
            $query->orderBy($orderBy, $orderType);
        }

        // Paginação
        $perPage = (int) $request->get('per_page', 15);
        if (!in_array($perPage, [10, 15, 25, 50, 100])) {
            $perPage = 15;
        }

        $backups = $query->with('restoredBy')->paginate($perPage)->withQueryString();

        // Estatísticas
        $stats = [
            'total' => UserBackup::count(),
            'active' => UserBackup::valid()->count(),
            'restored' => UserBackup::where('is_restored', true)->count(),
            'expired' => UserBackup::expired()->notRestored()->count(),
        ];

        return view('admin::users.deleted', [
            'backups' => $backups,
            'stats' => $stats
        ]);
    }

    public function show($id)
    {
        $backup = UserBackup::findOrFail($id);

        // Tentar ler dados do backup
        $backupData = null;
        if (file_exists($backup->backup_path)) {
            try {
                $jsonData = file_get_contents($backup->backup_path);
                $backupData = json_decode($jsonData, true);
            } catch (\Exception $e) {
                // Erro ao ler arquivo
            }
        }

        return view('admin::users.deleted-show', [
            'backup' => $backup,
            'backupData' => $backupData
        ]);
    }

    public function restore($id, Request $request)
    {
        $backup = UserBackup::findOrFail($id);

        // Verificar se pode ser restaurado
        if (!$backup->canBeRestored()) {
            if ($backup->is_restored) {
                return back()->with('error', __('Este backup já foi restaurado.'));
            }
            if ($backup->isExpired()) {
                return back()->with('error', __('Este backup expirou e não pode ser restaurado.'));
            }
            if (!file_exists($backup->backup_path)) {
                return back()->with('error', __('Arquivo de backup não encontrado.'));
            }
            return back()->with('error', __('Este backup não pode ser restaurado.'));
        }

        try {
            $backupService = new UserBackupService();
            $adminId = auth()->user()->id;
            
            $user = $backupService->restoreBackup($backup, $adminId);

            if ($user) {
                // Log da atividade
                logActivity($user->email, 'account_restored', __('Account restored from backup by admin. Backup ID: :backup_id', ['backup_id' => $backup->id]));

                return redirect()->route('admin-edit-user', $user->id)
                    ->with('success', __('Conta restaurada com sucesso!'));
            }

            return back()->with('error', __('Erro ao restaurar conta. Por favor, tente novamente.'));

        } catch (\Exception $e) {
            \Log::error("Erro ao restaurar backup ID: {$id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', __('Erro ao restaurar conta: :error', ['error' => $e->getMessage()]));
        }
    }

    public function download($id)
    {
        $backup = UserBackup::findOrFail($id);

        if (!file_exists($backup->backup_path)) {
            abort(404, __('Arquivo de backup não encontrado.'));
        }

        return response()->download($backup->backup_path, $backup->backup_file, [
            'Content-Type' => 'application/json',
        ]);
    }

    public function delete($id, Request $request)
    {
        $backup = UserBackup::findOrFail($id);

        // Não permitir deletar backups que já foram restaurados
        if ($backup->is_restored) {
            return back()->with('error', __('Não é possível deletar um backup que já foi restaurado.'));
        }

        try {
            // Deletar arquivo físico
            if (file_exists($backup->backup_path)) {
                unlink($backup->backup_path);
            }

            // Deletar registro
            $backup->delete();

            return back()->with('success', __('Backup deletado com sucesso.'));

        } catch (\Exception $e) {
            \Log::error("Erro ao deletar backup ID: {$id}", [
                'error' => $e->getMessage()
            ]);

            return back()->with('error', __('Erro ao deletar backup: :error', ['error' => $e->getMessage()]));
        }
    }
}

