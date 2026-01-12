<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Elementdb
 * 
 * @property int $id
 * @property int $user
 * @property int|null $element
 * @property string|null $email
 * @property string|null $database
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Elementdb extends Model
{
	protected $table = 'elementdb';

	protected $casts = [
		'user' => 'int',
		'element' => 'int'
	];
}
