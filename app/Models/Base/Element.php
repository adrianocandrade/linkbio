<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Element
 * 
 * @property int $id
 * @property int $user
 * @property string $slug
 * @property string|null $name
 * @property string|null $thumbnail
 * @property string|null $element
 * @property string|null $content
 * @property string|null $settings
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Element extends Model
{
	protected $table = 'elements';

	protected $casts = [
		'user' => 'int',
		'position' => 'int'
	];
}
