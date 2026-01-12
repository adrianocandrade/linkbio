<?php

namespace App\Models;

use App\Models\Base\Course as BaseCourse;

class Course extends BaseCourse
{
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
		'settings' => 'array',
		'banner' => 'array',
		'course_level' => 'array',
		'course_includes' => 'array'
	];
}
