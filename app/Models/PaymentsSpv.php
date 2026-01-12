<?php

namespace App\Models;

use App\Models\Base\PaymentsSpv as BasePaymentsSpv;

class PaymentsSpv extends BasePaymentsSpv
{
	protected $fillable = [
		'sxref',
		'is_paid',
		'price',
		'method',
		'method_ref',
		'callback',
		'info',
		'meta',
		'currency'
	];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'meta' => 'array',
        'keys' => 'array',
    ];
}
