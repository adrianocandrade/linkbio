<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductShippingLocation extends Model
{
	protected $table = 'product_shipping_locations';

	protected $casts = [
		'user' => 'int',
		'shipping_id' => 'int',
		'price' => 'float'
	];
	
	protected $fillable = [
		'user',
		'shipping_id',
		'name',
		'description',
		'price',
		'extra'
	];
}
