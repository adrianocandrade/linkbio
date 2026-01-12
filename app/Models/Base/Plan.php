<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * 
 * @property int $id
 * @property string $name
 * @property string|null $slug
 * @property string $status
 * @property string|null $price
 * @property string|null $settings
 * @property int $defaults
 * @property string|null $extra
 * @property string $price_type
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Plan extends Model
{
	protected $table = 'plans';

	protected $casts = [
		'defaults' => 'int',
		'position' => 'int'
	];
}
