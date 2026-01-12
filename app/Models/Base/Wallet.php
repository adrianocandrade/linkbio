<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * 
 * @property int $id
 * @property int $user
 * @property float $balance
 * @property string $default_country
 * @property string $default_currency
 * @property string|null $default_method
 * @property string $status
 * @property string|null $settlement
 * @property string|null $pin
 * @property string|null $extra
 * @property int $rave_setup
 * @property string|null $rave_subaccount
 * @property string|null $rave_payout
 * @property int $stripe_setup
 * @property string|null $stripe_info
 * @property int $wallet_setup
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Wallet extends Model
{
	protected $table = 'wallet';

	protected $casts = [
		'user' => 'int',
		'balance' => 'float',
		'rave_setup' => 'int',
		'stripe_setup' => 'int',
		'wallet_setup' => 'int'
	];
}
