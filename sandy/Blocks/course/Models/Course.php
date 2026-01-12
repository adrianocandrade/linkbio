<?php

namespace Sandy\Blocks\course\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
	protected $table = 'courses';

	protected $fillable = [
		'user',
		'name',
		'status',
		'price_type',
		'price',
		'price_pwyw',
		'compare_price',
		'course_level',
		'course_duration',
		'tags',
		'banner',
		'description'
	];

	protected $casts = [
		'user' => 'int',
		'status' => 'int',
		'price_type' => 'int',
		'price' => 'float',
		'course_expiry_type' => 'int',
		'position' => 'int',

		
		'settings' => 'array',
		'banner' => 'array',
		'course_level' => 'array',
		'course_includes' => 'array'
	];
}
