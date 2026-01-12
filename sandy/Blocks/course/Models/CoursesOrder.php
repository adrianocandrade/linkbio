<?php

namespace Sandy\Blocks\course\Models;

use Illuminate\Database\Eloquent\Model;

class CoursesOrder extends Model
{
	protected $table = 'courses_order';

	protected $casts = [
		'user' => 'int',
		'payee_user_id' => 'int',
		'course_id' => 'int',
		'price' => 'float'
	];
	
	protected $fillable = [
		'user',
		'payee_user_id',
		'course_id',
		'details',
		'currency',
		'email',
		'ref',
		'price',
		'extra',
		'status'
	];
}
