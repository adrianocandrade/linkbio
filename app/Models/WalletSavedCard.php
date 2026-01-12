<?php

namespace App\Models;

use App\Models\Base\WalletSavedCard as BaseWalletSavedCard;

class WalletSavedCard extends BaseWalletSavedCard
{
	protected $hidden = [
		'token'
	];

	protected $fillable = [
		'user',
		'token',
		'payload',
		'extra'
	];

	protected $casts = [
		'payload' => 'array',
		'extra'   => 'array'
	];
}
