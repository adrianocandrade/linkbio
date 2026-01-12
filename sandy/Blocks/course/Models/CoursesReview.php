<?php

namespace Sandy\Blocks\course\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesReview extends Model
{
	protected $table = 'courses_reviews';

	protected $fillable = [
		'user',
		'reviewer_id',
		'course_id',
		'rating',
		'review'
	];

	protected $casts = [
		'user' => 'int',
		'reviewer_id' => 'int',
		'course_id' => 'int',

		'review' => 'array'
	];
}
