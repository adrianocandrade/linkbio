<?php

namespace App\Models;

use App\Models\Base\CoursesSetting as BaseCoursesSetting;

class CoursesSetting extends BaseCoursesSetting
{
	protected $fillable = [
		'user',
		'name',
		'store_logo',
		'enable_courses',
		'setup',
		'settings'
	];
}
