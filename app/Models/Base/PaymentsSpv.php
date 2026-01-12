<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentsSpv
 * 
 * @property int $id
 * @property string|null $sxref
 * @property string|null $email
 * @property string|null $currency
 * @property int $status
 * @property int $is_paid
 * @property float|null $price
 * @property string|null $method
 * @property string|null $method_ref
 * @property string|null $callback
 * @property string|null $keys
 * @property string|null $meta
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class PaymentsSpv extends Model
{
	protected $table = 'payments_spv';

	protected $casts = [
		'status' => 'int',
		'is_paid' => 'int',
		'price' => 'float'
	];
}
