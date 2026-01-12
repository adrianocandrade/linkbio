<?php

namespace App\Models;

use App\Models\Base\YettiSpv as BaseYettiSpv;

class YettiSpv extends BaseYettiSpv
{
	protected $fillable = [
		'user',
		'sxref',
		'email',
		'currency',
		'is_paid',
		'price',
		'method',
		'method_ref',
		'callback',
		'meta'
	];

	protected $casts = [
		'meta' => 'array'
	];
}
