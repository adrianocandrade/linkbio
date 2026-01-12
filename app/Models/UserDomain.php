<?php

namespace App\Models;

use App\Models\Base\UserDomain as BaseUserDomain;

class UserDomain extends BaseUserDomain
{
	protected $fillable = [
		'user',
		'is_active',
		'scheme',
		'host',
		'settings'
	];
}
