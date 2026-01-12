<?php

namespace App\Models;

use App\Models\Base\Blog as BaseBlog;

class Pages extends BaseBlog
{
	protected $fillable = [
		'location',
		'name',
		'status',
		'type',
		'thumbnail',
		'description',
		'settings',
		'author',
		'ttr',
		'position',
		'total_views'
	];

	protected $casts = [
		'settings' => 'array',
	];
}
