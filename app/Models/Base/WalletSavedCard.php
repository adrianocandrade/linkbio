<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class WalletSavedCard
 * 
 * @property int $id
 * @property int $user
 * @property string|null $token
 * @property string|null $last_four
 * @property string|null $payload
 * @property string|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class WalletSavedCard extends Model
{
	protected $table = 'wallet_saved_cards';

	protected $casts = [
		'user' => 'int'
	];
}
