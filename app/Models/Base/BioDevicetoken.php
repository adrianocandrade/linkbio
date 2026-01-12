<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BioDevicetoken
 * 
 * @property int $id
 * @property int|null $user
 * @property string $device_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class BioDevicetoken extends Model
{
	protected $table = 'bio_devicetoken';

	protected $casts = [
		'user' => 'int'
	];
}
