<?php

namespace App\Models;

use App\Models\Base\PlansHistory as BasePlansHistory;

class PlansHistory extends BasePlansHistory
{
	protected $fillable = [
		'plan_id',
		'user_id'
	];

	public static function count_history($id){
        if (!$plan = \App\Models\Plan::find($id)) {
            return false;
        }

        return \App\Models\PlansHistory::where('plan_id', $plan->id)->count();
	}
}
