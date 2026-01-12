<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CoursesSetting
 * 
 * @property int $id
 * @property int $user
 * @property string|null $name
 * @property string|null $store_logo
 * @property int $enable_courses
 * @property int $setup
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class CoursesSetting extends Model
{
	protected $table = 'courses_settings';

	protected $casts = [
		'user' => 'int',
		'enable_courses' => 'int',
		'setup' => 'int'
	];
}
