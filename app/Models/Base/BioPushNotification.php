<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BioPushNotification
 * 
 * @property int $id
 * @property int|null $user
 * @property string|null $content
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class BioPushNotification extends Model
{
	protected $table = 'bio_push_notification';

	protected $casts = [
		'user' => 'int'
	];
}
