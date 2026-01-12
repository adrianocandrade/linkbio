<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentsSpvHistory
 * 
 * @property int $id
 * @property int|null $spv_id
 * @property int $status
 * @property string|null $method
 * @property string|null $method_ref
 * @property string|null $method_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class PaymentsSpvHistory extends Model
{
	protected $table = 'payments_spv_history';

	protected $casts = [
		'spv_id' => 'int',
		'status' => 'int'
	];
}
