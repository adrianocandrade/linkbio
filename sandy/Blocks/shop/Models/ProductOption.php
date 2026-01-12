<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class ProductOption extends Model
{
	protected $table = 'product_options';

	protected $casts = [
		'user' => 'int',
		'product_id' => 'int',
		'price' => 'float',
		'stock' => 'int',
		'position' => 'int'
	];
	
	protected $fillable = [
		'user',
		'product_id',
		'name',
		'price',
		'stock',
		'description',
		'files',
		'position'
	];
}
