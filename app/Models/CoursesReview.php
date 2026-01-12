<?php

namespace App\Models;

use App\Models\Base\CoursesReview as BaseCoursesReview;

class CoursesReview extends BaseCoursesReview
{
	protected $fillable = [
		'user',
		'reviewer_id',
		'course_id',
		'rating',
		'review'
	];

	protected $casts = [
		'review' => 'array'
	];
}
