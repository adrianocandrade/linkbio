<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SupportConversation
 * 
 * @property int $id
 * @property int $user
 * @property string|null $topic
 * @property string|null $description
 * @property int $status
 * @property string|null $extra
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class SupportConversation extends Model
{
	protected $table = 'support_conversations';

	protected $casts = [
		'user' => 'int',
		'status' => 'int'
	];
}
