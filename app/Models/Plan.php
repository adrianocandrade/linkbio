<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Plan extends Model
{
	protected $table = 'plans';

	protected $fillable = [
		'name',
		'slug',
		'status',
		'price',
		'settings'
	];

    protected $casts = [
        'settings' => 'array',
        'price' => 'array',
        'extra' => 'array'
    ];


    public static function count_users($id){
        if (!$plan = \App\Models\Plan::find($id)) {
            return false;
        }

        return \App\Models\PlansUser::where('plan_id', $plan->id)->count();
    }
}
