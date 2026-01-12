<?php

namespace App\Models;

use App\Models\Base\BioDevicetoken as BaseBioDevicetoken;

class BioDevicetoken extends BaseBioDevicetoken
{
	protected $hidden = [
		'device_token'
	];

	protected $fillable = [
		'user',
		'device_token'
	];
}
