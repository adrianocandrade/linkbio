<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PlansUser
 * 
 * @property int $id
 * @property int $plan_id
 * @property int $user_id
 * @property Carbon|null $plan_due
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class PlansUser extends Model
{
	protected $table = 'plans_users';

	protected $casts = [
		'plan_id' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'plan_due'
	];
}
