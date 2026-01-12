<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class TipCollection
 * 
 * @property int $id
 * @property int $user
 * @property int|null $payee_user_id
 * @property int|null $element_id
 * @property int $is_private
 * @property float|null $amount
 * @property string|null $currency
 * @property string|null $info
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class TipCollection extends Model
{
	protected $table = 'tip_collection';

	protected $casts = [
		'user' => 'int',
		'payee_user_id' => 'int',
		'element_id' => 'int',
		'is_private' => 'int',
		'amount' => 'float'
	];
}
