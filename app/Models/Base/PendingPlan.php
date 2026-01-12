<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PendingPlan
 * 
 * @property int $id
 * @property int $user
 * @property int $status
 * @property string|null $email
 * @property string|null $name
 * @property string|null $ref
 * @property int|null $plan
 * @property string|null $duration
 * @property string|null $info
 * @property string $method
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class PendingPlan extends Model
{
	protected $table = 'pending_plan';

	protected $casts = [
		'user' => 'int',
		'status' => 'int',
		'plan' => 'int'
	];
}
