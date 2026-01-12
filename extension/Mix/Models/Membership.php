<?php

namespace Modules\Mix\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\BelongsToWorkspace;

class Membership extends Model
{
    use BelongsToWorkspace;

    protected $fillable = [
        'workspace_id',
        'user_id',
        'name',
        'description',
        'price',
        'billing_cycle',
        'permissions',
        'limits',
        'status',
    ];

    protected $casts = [
        'permissions' => 'array',
        'limits' => 'array',
        'price' => 'decimal:2',
    ];

    public function subscribers()
    {
        return $this->hasMany(MembershipSubscription::class);
    }
}
