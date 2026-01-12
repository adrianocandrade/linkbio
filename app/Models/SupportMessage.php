<?php

namespace App\Models;

use App\Models\Base\SupportMessage as BaseSupportMessage;

class SupportMessage extends BaseSupportMessage
{
	protected $fillable = [
		'conversation_id',
		'user_id',
		'from',
		'type',
		'data',
		'seen',
		'extra'
	];
}
