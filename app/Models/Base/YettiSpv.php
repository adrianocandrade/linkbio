<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class YettiSpv
 * 
 * @property int $id
 * @property int $user
 * @property int|null $payee_user_id
 * @property string|null $sxref
 * @property string|null $email
 * @property string|null $currency
 * @property int $is_paid
 * @property float|null $price
 * @property float|null $split_price
 * @property string|null $method
 * @property string|null $method_ref
 * @property string|null $callback
 * @property string|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class YettiSpv extends Model
{
	protected $table = 'yetti_spv';

	protected $casts = [
		'user' => 'int',
		'payee_user_id' => 'int',
		'is_paid' => 'int',
		'price' => 'float',
		'split_price' => 'float'
	];
}
