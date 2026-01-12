<?php

namespace App\Models;

use App\Models\Base\PendingPlan as BasePendingPlan;

class PendingPlan extends BasePendingPlan
{
	protected $fillable = [
		'user',
		'status',
		'email',
		'name',
		'ref',
		'plan',
		'duration',
		'info',
		'method'
	];

	protected $casts = [
		'info' => 'array'
	];
}
