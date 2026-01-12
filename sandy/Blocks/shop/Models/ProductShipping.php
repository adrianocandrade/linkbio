<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShipping extends Model
{
	protected $table = 'product_shipping';


	protected $fillable = [
		'user',
		'country_iso',
		'country',
		'locations',
		'extra'
	];

	protected $casts = [
		'user' => 'int',
		'locations' => 'array',
		'extra'		=> 'array'
	];
}
