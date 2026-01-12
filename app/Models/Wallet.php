<?php

namespace App\Models;

use App\Models\Base\Wallet as BaseWallet;

class Wallet extends BaseWallet
{
	protected $fillable = [
		'user',
		'balance',
		'default_country',
		'status',
		'settlement',
		'pin',
		'extra',
		'rave_subaccount_id',
		'kuda_wallet_id',
		'kuda_wallet',
		'wallet_setup'
	];

	protected $casts = [
		'settlement' => 'array',
		'extra'		 => 'array',
		'kuda_wallet' => 'array',
		'rave_payout' => 'array',
		'rave_subaccount' => 'array'
	];
}
