<?php

namespace App\Models;

use App\Models\Base\Element as BaseElement;

class Element extends BaseElement
{
	protected $fillable = [
		'user',
		'slug',
		'name',
		'thumbnail',
		'element',
		'content',
		'settings',
		'position'
	];

	protected $casts = [
		'content' => 'array',
		'settings' => 'array',
		'thumbnail' => 'array'
	];
}
