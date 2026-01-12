<?php

namespace App\Models;

use App\Models\Base\BioPushNotification as BaseBioPushNotification;

class BioPushNotification extends BaseBioPushNotification
{
	protected $fillable = [
		'user',
		'content'
	];

	protected $casts = [
		'content' => 'array'
	];
}
