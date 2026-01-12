<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderTimeline extends Model
{
	protected $table = 'product_order_timeline';
	protected $fillable = [
		'user',
		'tId',
		'title',
		'description',
		'postedBy',
		'updatedBy'
	];


	protected $casts = [
		'user' => 'int',
		'tid' => 'int',
		'data' => 'array'
	];
}
