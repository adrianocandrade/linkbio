<?php

namespace App\Models;

use App\Models\Base\WalletTransaction as BaseWalletTransaction;

class WalletTransaction extends BaseWalletTransaction
{
	protected $fillable = [
		'user',
		'amount',
		'transaction_id',
		'transaction'
	];


	protected $casts = [
		'transaction' => 'array',
		'payload' => 'array'
	];
}
