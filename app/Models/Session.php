<?php

namespace App\Models;

use App\Models\Base\Session as BaseSession;

class Session extends BaseSession
{
	protected $fillable = [
		'user_id',
		'user_bio',
		'ip_address',
		'user_agent',
		'payload',
		'tracking',
		'last_activity'
	];
}
