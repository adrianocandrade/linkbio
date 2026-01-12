<?php

namespace Sandy\Blocks\shop\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = [
		'user',
		'name',
		'slug',
		'status',
		'price',
		'enablePwyw',
		'enableCompareprice',
		'comparePrice',
		'enableOptions',
		'isDeal',
		'dealPrice',
		'dealEnds',
		'enableBid',
		'stock',
		'productType',
		'media',
		'description',
		'stock_management',
		'postedBy',
		'updatedBy',
		'ribbon',
		'seo',
		'api',
		'files',
		'extra',
		'position'
	];

	protected $table = 'products';

	protected $casts = [
		'user' => 'int',
		'status' => 'int',
		'price_type' => 'int',
		'price' => 'float',
		'enableOptions' => 'int',
		'isDeal' => 'int',
		'enableBid' => 'int',
		'stock' => 'int',
		'productType' => 'int',
		'position' => 'int',

		
		'media' => 'array',
		'extra' => 'array',
		'banner' => 'array',
		'stock_settings' => 'array',
		'seo' => 'array',
		'files' => 'array'
	];

	protected $dates = [
		'dealEnds'
	];
}
