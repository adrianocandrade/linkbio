<?php

namespace App\Services;

use App\User;
use App\Models\UserBackup;
use App\Models\Block;
use App\Models\Blockselement;
use App\Models\Element;
use App\Models\Elementdb;
use App\Models\Highlight;
use App\Models\Pixel;
use App\Models\PlansUser;
use App\Models\PlansHistory;
use App\Models\Domain;
use App\Models\Visitor;
use App\Models\Authactivity;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use App\Models\UserUploadPath;
use App\Models\Workspace;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserBackupService
{
    /**
     * Cria um backup completo do usuário e todos os dados relacionados
     *
     * @param User $user
     * @return UserBackup|null
     */
    public function createBackup(User $user)
    {
        try {
            $backupData = $this->collectUserData($user);
            
            // Gerar nome do arquivo
            $timestamp = time();
            $filename = "user_backup_{$user->id}_{$timestamp}.json";
            
            // Diretório de backups
            $backupDir = storage_path('app/backups/users');
            if (!is_dir($backupDir)) {
                mkdir($backupDir, 0755, true);
            }
            
            $filepath = $backupDir . '/' . $filename;
            
            // Salvar backup em JSON
            $jsonData = json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            file_put_contents($filepath, $jsonData);
            
            // Calcular tamanho do arquivo
            $fileSize = filesize($filepath);
            
            // Data de expiração (6 meses)
            $expiresAt = Carbon::now()->addMonths(6);
            
            // Criar registro no banco
            $backup = UserBackup::create([
                'user_id' => $user->id,
                'username' => $user->username,
                'email' => $user->email,
                'name' => $user->name,
                'backup_file' => $filename,
                'backup_path' => $filepath,
                'file_size' => $fileSize,
                'backup_date' => Carbon::now(),
                'expires_at' => $expiresAt,
                'backup_metadata' => [
                    'total_blocks' => count($backupData['blocks'] ?? []),
                    'total_elements' => count($backupData['elements'] ?? []),
                    'total_workspaces' => count($backupData['workspaces'] ?? []),
                    'has_plan' => !empty($backupData['plan']),
                    'backup_version' => '1.0'
                ]
            ]);
            
            Log::info("Backup criado para usuário ID: {$user->id}, Backup ID: {$backup->id}");
            
            return $backup;
            
        } catch (\Exception $e) {
            Log::error("Erro ao criar backup do usuário ID: {$user->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Coleta todos os dados relacionados ao usuário
     *
     * @param User $user
     * @return array
     */
    protected function collectUserData(User $user)
    {
        // Dados básicos do usuário
        $userData = $user->toArray();
        
        // Workspaces
        $workspaces = Workspace::where('user_id', $user->id)->get()->toArray();
        
        // Blocks
        $blocks = Block::where('user', $user->id)->get()->toArray();
        
        // Blocks Elements
        $blocksElements = Blockselement::where('user', $user->id)->get()->toArray();
        
        // Elements
        $elements = Element::where('user', $user->id)->get()->toArray();
        
        // Elements DB
        $elementsDb = Elementdb::where('user', $user->id)->get()->toArray();
        
        // Highlights
        $highlights = Highlight::where('user', $user->id)->get()->toArray();
        
        // Pixels
        $pixels = Pixel::where('user', $user->id)->get()->toArray();
        
        // Plans
        $planUser = PlansUser::where('user_id', $user->id)->first();
        $plan = $planUser ? $planUser->toArray() : null;
        
        // Plan History
        $plansHistory = PlansHistory::where('user_id', $user->id)->get()->toArray();
        
        // Domains
        $domains = Domain::where('user', $user->id)->get()->toArray();
        
        // Visitors (últimos 100 para não pesar muito)
        $visitors = Visitor::where('user', $user->id)
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get()
            ->toArray();
        
        // Auth Activities
        $authActivities = Authactivity::where('user', $user->id)
            ->orderBy('id', 'DESC')
            ->limit(100)
            ->get()
            ->toArray();
        
        // Support Conversations
        $supportConversations = SupportConversation::where('user', $user->id)->get()->toArray();
        
        // Support Messages
        $supportMessages = SupportMessage::where('user_id', $user->id)->get()->toArray();
        
        // User Upload Paths
        $uploadPaths = UserUploadPath::where('user', $user->id)->get()->toArray();
        
        return [
            'user' => $userData,
            'workspaces' => $workspaces,
            'blocks' => $blocks,
            'blocks_elements' => $blocksElements,
            'elements' => $elements,
            'elements_db' => $elementsDb,
            'highlights' => $highlights,
            'pixels' => $pixels,
            'plan' => $plan,
            'plans_history' => $plansHistory,
            'domains' => $domains,
            'visitors' => $visitors,
            'auth_activities' => $authActivities,
            'support_conversations' => $supportConversations,
            'support_messages' => $supportMessages,
            'upload_paths' => $uploadPaths,
            'backup_created_at' => Carbon::now()->toIso8601String()
        ];
    }

    /**
     * Restaura um backup de usuário
     *
     * @param UserBackup $backup
     * @param int $restoredBy Admin ID que está restaurando
     * @return User|null
     */
    public function restoreBackup(UserBackup $backup, $restoredBy = null)
    {
        try {
            if (!$backup->canBeRestored()) {
                throw new \Exception("Backup não pode ser restaurado (já restaurado, expirado ou arquivo não encontrado)");
            }
            
            if (!file_exists($backup->backup_path)) {
                throw new \Exception("Arquivo de backup não encontrado: {$backup->backup_path}");
            }
            
            // Ler dados do backup
            $jsonData = file_get_contents($backup->backup_path);
            $backupData = json_decode($jsonData, true);
            
            if (!$backupData || !isset($backupData['user'])) {
                throw new \Exception("Dados do backup inválidos ou corrompidos");
            }
            
            DB::beginTransaction();
            
            try {
                $userData = $backupData['user'];
                $originalUserId = $userData['id'];
                
                // Remover campos que não devem ser restaurados
                unset($userData['id'], $userData['created_at'], $userData['updated_at'], $userData['deleted_at']);
                
                // Verificar se email/username já existem
                $existingUser = User::withTrashed()->where('email', $userData['email'])
                    ->orWhere('username', $userData['username'])
                    ->first();
                
                if ($existingUser && $existingUser->id != $originalUserId) {
                    // Se usuário já existe, restaurar como soft delete primeiro
                    if (!$existingUser->trashed()) {
                        throw new \Exception("Já existe um usuário ativo com este email ou username");
                    }
                    // Se está deletado, restaurar ele
                    $existingUser->restore();
                    $user = $existingUser;
                } else {
                    // Criar novo usuário
                    $user = User::create($userData);
                }
                
                // Restaurar workspaces
                if (isset($backupData['workspaces']) && is_array($backupData['workspaces'])) {
                    foreach ($backupData['workspaces'] as $workspaceData) {
                        unset($workspaceData['id'], $workspaceData['created_at'], $workspaceData['updated_at']);
                        $workspaceData['user_id'] = $user->id;
                        Workspace::create($workspaceData);
                    }
                }
                
                // Restaurar blocks
                if (isset($backupData['blocks']) && is_array($backupData['blocks'])) {
                    foreach ($backupData['blocks'] as $blockData) {
                        unset($blockData['id'], $blockData['created_at'], $blockData['updated_at']);
                        $blockData['user'] = $user->id;
                        Block::create($blockData);
                    }
                }
                
                // Restaurar blocks elements
                if (isset($backupData['blocks_elements']) && is_array($backupData['blocks_elements'])) {
                    foreach ($backupData['blocks_elements'] as $blockElementData) {
                        unset($blockElementData['id'], $blockElementData['created_at'], $blockElementData['updated_at']);
                        $blockElementData['user'] = $user->id;
                        Blockselement::create($blockElementData);
                    }
                }
                
                // Restaurar elements
                if (isset($backupData['elements']) && is_array($backupData['elements'])) {
                    foreach ($backupData['elements'] as $elementData) {
                        unset($elementData['id'], $elementData['created_at'], $elementData['updated_at']);
                        $elementData['user'] = $user->id;
                        Element::create($elementData);
                    }
                }
                
                // Restaurar elements_db
                if (isset($backupData['elements_db']) && is_array($backupData['elements_db'])) {
                    foreach ($backupData['elements_db'] as $elementDbData) {
                        unset($elementDbData['id'], $elementDbData['created_at'], $elementDbData['updated_at']);
                        $elementDbData['user'] = $user->id;
                        Elementdb::create($elementDbData);
                    }
                }
                
                // Restaurar highlights
                if (isset($backupData['highlights']) && is_array($backupData['highlights'])) {
                    foreach ($backupData['highlights'] as $highlightData) {
                        unset($highlightData['id'], $highlightData['created_at'], $highlightData['updated_at']);
                        $highlightData['user'] = $user->id;
                        Highlight::create($highlightData);
                    }
                }
                
                // Restaurar pixels
                if (isset($backupData['pixels']) && is_array($backupData['pixels'])) {
                    foreach ($backupData['pixels'] as $pixelData) {
                        unset($pixelData['id'], $pixelData['created_at'], $pixelData['updated_at']);
                        $pixelData['user'] = $user->id;
                        Pixel::create($pixelData);
                    }
                }
                
                // Restaurar plan
                if (isset($backupData['plan']) && is_array($backupData['plan'])) {
                    $planData = $backupData['plan'];
                    unset($planData['id'], $planData['created_at'], $planData['updated_at']);
                    $planData['user_id'] = $user->id;
                    PlansUser::create($planData);
                }
                
                // Restaurar plan history
                if (isset($backupData['plans_history']) && is_array($backupData['plans_history'])) {
                    foreach ($backupData['plans_history'] as $planHistoryData) {
                        unset($planHistoryData['id'], $planHistoryData['created_at'], $planHistoryData['updated_at']);
                        $planHistoryData['user_id'] = $user->id;
                        PlansHistory::create($planHistoryData);
                    }
                }
                
                // Restaurar domains
                if (isset($backupData['domains']) && is_array($backupData['domains'])) {
                    foreach ($backupData['domains'] as $domainData) {
                        unset($domainData['id'], $domainData['created_at'], $domainData['updated_at']);
                        $domainData['user'] = $user->id;
                        Domain::create($domainData);
                    }
                }
                
                // Restaurar upload paths (apenas metadados, arquivos físicos não são restaurados)
                if (isset($backupData['upload_paths']) && is_array($backupData['upload_paths'])) {
                    foreach ($backupData['upload_paths'] as $uploadPathData) {
                        unset($uploadPathData['id'], $uploadPathData['created_at'], $uploadPathData['updated_at']);
                        $uploadPathData['user'] = $user->id;
                        UserUploadPath::create($uploadPathData);
                    }
                }
                
                // Marcar backup como restaurado
                $backup->update([
                    'is_restored' => true,
                    'restored_at' => Carbon::now(),
                    'restored_by' => $restoredBy,
                    'user_id' => $user->id
                ]);
                
                DB::commit();
                
                Log::info("Backup restaurado. Backup ID: {$backup->id}, User ID: {$user->id}, Restaurado por: {$restoredBy}");
                
                return $user;
                
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
            
        } catch (\Exception $e) {
            Log::error("Erro ao restaurar backup ID: {$backup->id}", [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Remove backups expirados
     *
     * @return int Número de backups removidos
     */
    public function cleanExpiredBackups()
    {
        $expiredBackups = UserBackup::expired()->notRestored()->get();
        $deletedCount = 0;
        
        foreach ($expiredBackups as $backup) {
            try {
                // Deletar arquivo físico
                if (file_exists($backup->backup_path)) {
                    unlink($backup->backup_path);
                }
                
                // Deletar registro
                $backup->delete();
                $deletedCount++;
                
            } catch (\Exception $e) {
                Log::error("Erro ao deletar backup expirado ID: {$backup->id}", [
                    'error' => $e->getMessage()
                ]);
            }
        }
        
        Log::info("Limpeza de backups expirados concluída. {$deletedCount} backups removidos.");
        
        return $deletedCount;
    }
}

