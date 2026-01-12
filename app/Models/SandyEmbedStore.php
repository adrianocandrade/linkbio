<?php

namespace App\Models;

use App\Models\Base\SandyEmbedStore as BaseSandyEmbedStore;

class SandyEmbedStore extends BaseSandyEmbedStore
{
	protected $fillable = [
		'link',
		'data'
	];


	protected $casts = [
		'data' => 'array'
	];
}
