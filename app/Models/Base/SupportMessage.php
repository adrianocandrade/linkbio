<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupportMessage
 * 
 * @property int $id
 * @property int $conversation_id
 * @property int $user_id
 * @property string $from
 * @property int|null $from_id
 * @property string $type
 * @property string|null $data
 * @property string $seen
 * @property string|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class SupportMessage extends Model
{
	protected $table = 'support_messages';

	protected $casts = [
		'conversation_id' => 'int',
		'user_id' => 'int',
		'from_id' => 'int'
	];
}
