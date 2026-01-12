<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrderNote extends Model
{
	protected $table = 'product_order_note';
	protected $fillable = [
		'user',
		'tId',
		'note'
	];

	protected $casts = [
		'user' => 'int',
		'tid' => 'int'
	];
}
