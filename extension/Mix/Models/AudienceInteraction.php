<?php

namespace Modules\Mix\Models;

use Illuminate\Database\Eloquent\Model;

class AudienceInteraction extends Model
{
    protected $fillable = [
        'contact_id',
        'workspace_id',
        'type',
        'action',
        'amount',
        'metadata',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'metadata' => 'array',
    ];

    public $timestamps = false; // Apenas created_at

    protected $dates = ['created_at'];

    public function contact()
    {
        return $this->belongsTo(AudienceContact::class, 'contact_id');
    }

    public function workspace()
    {
        return $this->belongsTo(\App\Models\Workspace::class);
    }
}
