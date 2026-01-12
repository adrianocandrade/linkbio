<?php

namespace App\Models;

use App\Models\Base\StoreSetting as BaseStoreSetting;

class StoreSetting extends BaseStoreSetting
{
	protected $fillable = [
		'user',
		'store_same',
		'store_logo',
		'address',
		'store_address',
		'enable_store',
		'store_setup',
		'enable_personal_rewards',
		'kycSetup',
		'kyc',
		'banned',
		'shipping',
		'settings'
	];


	protected $casts = [
		'shipping' => 'array',
		'settings' => 'array'
	];
}
