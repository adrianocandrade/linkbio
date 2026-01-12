<?php

namespace App\Models;

use App\Models\Base\Config as BaseConfig;

class Config extends BaseConfig
{
	protected $fillable = [
		'k',
		'v'
	];
}
