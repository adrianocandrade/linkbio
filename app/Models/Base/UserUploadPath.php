<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserUploadPath
 * 
 * @property int $id
 * @property int|null $user
 * @property string|null $path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class UserUploadPath extends Model
{
	protected $table = 'user_upload_paths';

	protected $casts = [
		'user' => 'int'
	];
}
