<?php

namespace App\Models;

use App\Models\Base\SupportConversation as BaseSupportConversation;

class SupportConversation extends BaseSupportConversation
{
	protected $fillable = [
		'user',
		'status',
		'extra'
	];
}
