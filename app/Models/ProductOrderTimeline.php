<?php

namespace App\Models;

use App\Models\Base\ProductOrderTimeline as BaseProductOrderTimeline;

class ProductOrderTimeline extends BaseProductOrderTimeline
{
	protected $fillable = [
		'user',
		'tId',
		'title',
		'description',
		'postedBy',
		'updatedBy'
	];


	protected $casts = [
		'data' => 'array'
	];
}
