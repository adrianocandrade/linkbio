<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @package App\Models
 */
class PlansUser extends Model
{
	protected $table = 'plans_users';

	protected $casts = [
		'plan_id' => 'int',
		'user_id' => 'int',
		'settings' => 'array'
	];

	protected $dates = [
		'plan_due'
	];

	protected $fillable = [
		'plan_id',
		'user_id',
		'plan_due',
		'settings'
	];
	
    public function user(){
        return $this->belongsTo(\App\User::class, 'id');
    }
}
