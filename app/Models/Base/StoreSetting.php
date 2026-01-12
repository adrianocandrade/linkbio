<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StoreSetting
 * 
 * @property int $id
 * @property int $user
 * @property string|null $store_name
 * @property string|null $store_logo
 * @property string|null $store_address
 * @property int $enable_store
 * @property int $store_setup
 * @property int $enable_personal_rewards
 * @property int $kyc_setup
 * @property string|null $kyc
 * @property int $banned
 * @property string|null $shipping
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class StoreSetting extends Model
{
	protected $table = 'store_settings';

	protected $casts = [
		'user' => 'int',
		'enable_store' => 'int',
		'store_setup' => 'int',
		'enable_personal_rewards' => 'int',
		'kyc_setup' => 'int',
		'banned' => 'int'
	];
}
