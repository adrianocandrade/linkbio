<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 * 
 * @property int $id
 * @property int|null $user
 * @property int $is_active
 * @property string|null $scheme
 * @property string|null $host
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Domain extends Model
{
	protected $table = 'domains';

	protected $casts = [
		'user' => 'int',
		'is_active' => 'int'
	];
}
