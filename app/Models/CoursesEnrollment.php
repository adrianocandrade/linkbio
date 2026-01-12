<?php

namespace App\Models;

use App\Models\Base\CoursesEnrollment as BaseCoursesEnrollment;

class CoursesEnrollment extends BaseCoursesEnrollment
{
	protected $fillable = [
		'user',
		'payee_user_id',
		'course_id',
		'lession_taken'
	];

	protected $casts = [
		'lession_taken' => 'array'
	];
}
