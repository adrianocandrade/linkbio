<?php

namespace Modules\Mix\Models;

use Illuminate\Database\Eloquent\Model;

class AudienceContact extends Model
{
    protected $fillable = [
        'workspace_id',
        'user_id',
        'name',
        'email',
        'phone',
        'avatar',
        'source',
        'source_id',
        'metadata',
        'tags',
        'total_interactions',
        'total_spent',
        'last_interaction_at',
        'status',
        'subscribed_newsletter',
    ];

    protected $casts = [
        'metadata' => 'array',
        'tags' => 'array',
        'total_spent' => 'decimal:2',
        'last_interaction_at' => 'datetime',
        'subscribed_newsletter' => 'boolean',
    ];

    public function workspace()
    {
        return $this->belongsTo(\App\Models\Workspace::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    public function interactions()
    {
        return $this->hasMany(AudienceInteraction::class, 'contact_id');
    }
}
