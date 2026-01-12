<?php

namespace App\Models;

use App\Models\Base\TipCollection as BaseTipCollection;

class TipCollection extends BaseTipCollection
{
	protected $fillable = [
		'user',
		'payee_user_id',
		'element_id',
		'is_private',
		'amount',
		'currency',
		'info'
	];

	protected $casts = [
		'info' => 'array'
	];
}
