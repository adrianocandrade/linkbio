<?php

namespace App\Models;

use App\Models\Base\PaymentsSpvHistory as BasePaymentsSpvHistory;

class PaymentsSpvHistory extends BasePaymentsSpvHistory
{
	protected $fillable = [
		'spv_id',
		'status',
		'method',
		'method_ref',
		'method_data'
	];




	protected $casts = [
		'method_data' => 'array'
	];
}
