<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pixel
 * 
 * @property int $id
 * @property int $user
 * @property string|null $name
 * @property int $status
 * @property string|null $pixel_id
 * @property string|null $pixel_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Pixel extends Model
{
	protected $table = 'pixels';

	protected $casts = [
		'user' => 'int',
		'status' => 'int'
	];
}
