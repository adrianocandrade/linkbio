<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class YettiSpvHistory
 * 
 * @property int $id
 * @property string|null $spv_id
 * @property int $status
 * @property string|null $method
 * @property string|null $method_ref
 * @property string|null $payload_data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class YettiSpvHistory extends Model
{
	protected $table = 'yetti_spv_history';

	protected $casts = [
		'status' => 'int'
	];
}
