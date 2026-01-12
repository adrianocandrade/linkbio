<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class UserBackup extends Model
{
    protected $table = 'user_backups';

    protected $fillable = [
        'user_id',
        'username',
        'email',
        'name',
        'backup_file',
        'backup_path',
        'file_size',
        'backup_metadata',
        'backup_date',
        'expires_at',
        'is_restored',
        'restored_at',
        'restored_by'
    ];

    protected $casts = [
        'backup_date' => 'datetime',
        'expires_at' => 'datetime',
        'restored_at' => 'datetime',
        'backup_metadata' => 'array',
        'is_restored' => 'boolean',
        'file_size' => 'integer',
    ];

    /**
     * Relacionamento com o usuário restaurado (se existir)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relacionamento com o admin que restaurou
     */
    public function restoredBy()
    {
        return $this->belongsTo(User::class, 'restored_by');
    }

    /**
     * Verifica se o backup expirou
     */
    public function isExpired()
    {
        return $this->expires_at && Carbon::now()->greaterThan($this->expires_at);
    }

    /**
     * Verifica se o backup pode ser restaurado
     */
    public function canBeRestored()
    {
        return !$this->is_restored && !$this->isExpired() && file_exists($this->backup_path);
    }

    /**
     * Scope para backups não restaurados
     */
    public function scopeNotRestored($query)
    {
        return $query->where('is_restored', false);
    }

    /**
     * Scope para backups expirados
     */
    public function scopeExpired($query)
    {
        return $query->where('expires_at', '<', Carbon::now());
    }

    /**
     * Scope para backups válidos (não expirados e não restaurados)
     */
    public function scopeValid($query)
    {
        return $query->where('is_restored', false)
                    ->where('expires_at', '>', Carbon::now());
    }
}

