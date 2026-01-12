<?php

namespace App\Models;

use App\Models\Base\Blockselement as BaseBlockselement;

class Blockselement extends BaseBlockselement
{
	protected $table = 'blocks_element';
	
	protected $fillable = [
		'block_id',
		'thumbnail',
		'content',
		'settings',
		'position'
	];

	protected $casts = [
		'settings' => 'array',
		'content' => 'array',
		'thumbnail' => 'array'
	];
}
