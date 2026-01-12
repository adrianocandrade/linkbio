<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
	protected $table = 'product_order';

	protected $fillable = [
		'user',
		'payee_user_id',
		'details',
		'currency',
		'email',
		'ref',
		'price',
		'is_deal',
		'deal_discount',
		'products',
		'extra',
		'status'
	];

	protected $casts = [
		'user' => 'int',
		'payee_user_id' => 'int',
		'price' => 'float',
		'is_deal' => 'int',
		'deal_discount' => 'int',
		'status' => 'int',


		'details' => 'array',
		'products' => 'array',
		'extra' => 'array'
	];
}
