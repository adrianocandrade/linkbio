<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'status', 'is_default',
        'bio', 'avatar', 'settings', 'background', 'background_settings',
        'buttons', 'social', 'font', 'theme', 'color', 'avatar_settings',
        'seo', 'pwa', 'store', 'integrations', 'booking', 'payments'
    ];

    protected $casts = [
        'settings' => 'array',
        'background_settings' => 'array',
        'buttons' => 'object', // Matching User model usage
        'social' => 'array',
        'color' => 'array',
        'avatar_settings' => 'array',
        'seo' => 'array',
        'pwa' => 'array',
        'store' => 'array',
        'integrations' => 'array',
        'booking' => 'array',
        'payments' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
