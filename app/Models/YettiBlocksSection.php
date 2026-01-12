<?php

namespace App\Models;

use App\Models\Base\YettiBlocksSection as BaseYettiBlocksSection;

class YettiBlocksSection extends BaseYettiBlocksSection
{
	protected $fillable = [
		'user',
		'block_id',
		'thumbnail',
		'content',
		'position'
	];
	
	protected $casts = [
		'content' => 'array',
		'thumbnail' => 'array'
	];
}
