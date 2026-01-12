<?php

namespace App\Models;

use App\Models\Base\Product as BaseProduct;

class Product extends BaseProduct
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


	protected $casts = [
		'media' => 'array',
		'extra' => 'array',
		'banner' => 'array',
		'stock_settings' => 'array',
		'seo' => 'array',
		'files' => 'array'
	];
}
