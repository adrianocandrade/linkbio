<?php

namespace Sandy\Blocks\course\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesEnrollment extends Model
{
	protected $table = 'courses_enrollments';

	protected $fillable = [
		'user',
		'payee_user_id',
		'course_id',
		'lession_taken'
	];

	protected $casts = [
		'user' => 'int',
		'payee_user_id' => 'int',
		'course_id' => 'int',


		'lession_taken' => 'array'
	];
}
