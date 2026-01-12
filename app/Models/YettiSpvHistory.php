<?php

namespace App\Models;

use App\Models\Base\YettiSpvHistory as BaseYettiSpvHistory;

class YettiSpvHistory extends BaseYettiSpvHistory
{
	protected $fillable = [
		'spv_id',
		'status',
		'method',
		'method_ref',
		'payload_data'
	];


	protected $casts = [
		'payload_data' => 'array'
	];
}
