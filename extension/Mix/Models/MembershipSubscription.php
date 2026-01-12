<?php

namespace Modules\Mix\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToWorkspace;

class MembershipSubscription extends Model
{
    use BelongsToWorkspace;

    protected $fillable = [
        'membership_id',
        'contact_id',
        'workspace_id',
        'started_at',
        'expires_at',
        'cancelled_at',
        'payment_status',
        'last_payment_at',
        'next_payment_at',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'expires_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'last_payment_at' => 'datetime',
        'next_payment_at' => 'datetime',
    ];

    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    public function contact()
    {
        return $this->belongsTo(AudienceContact::class, 'contact_id');
    }
}
