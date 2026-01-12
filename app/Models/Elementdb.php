<?php

namespace App\Models;

use App\Models\Base\Elementdb as BaseElementdb;

class Elementdb extends BaseElementdb
{
	protected $fillable = [
		'user',
		'element',
		'email',
		'database'
	];

	protected $casts = [
		'database' => 'array'
	];
}
