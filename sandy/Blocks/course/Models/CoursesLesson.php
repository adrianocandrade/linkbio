<?php

namespace Sandy\Blocks\course\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesLesson extends Model
{
	protected $table = 'courses_lesson';

	protected $fillable = [
		'user',
		'course_id',
		'name',
		'description',
		'lesson_type',
		'status',
		'lesson_data',
		'settings'
	];

	protected $casts = [
		'user' => 'int',
		'course_id' => 'int',
		'status' => 'int',
		'position' => 'int',


		'lesson_data' => 'array',
		'settings'	  => 'array'
	];
}
