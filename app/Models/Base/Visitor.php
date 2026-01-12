<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Visitor
 * 
 * @property int $id
 * @property int|null $user
 * @property string|null $slug
 * @property string|null $session
 * @property string|null $ip
 * @property string|null $tracking
 * @property int $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Visitor extends Model
{
	protected $table = 'visitors';

	protected $casts = [
		'user' => 'int',
		'views' => 'int'
	];
}
