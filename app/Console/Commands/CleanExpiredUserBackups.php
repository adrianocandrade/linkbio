<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\UserBackupService;

class CleanExpiredUserBackups extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backups:clean-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove expired user backups (older than 6 months)';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando limpeza de backups expirados...');
        
        $backupService = new UserBackupService();
        $deletedCount = $backupService->cleanExpiredBackups();
        
        if ($deletedCount > 0) {
            $this->info("✓ {$deletedCount} backup(s) expirado(s) removido(s) com sucesso.");
        } else {
            $this->info('✓ Nenhum backup expirado encontrado.');
        }
        
        return Command::SUCCESS;
    }
}

