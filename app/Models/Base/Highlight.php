<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Highlight
 * 
 * @property int $id
 * @property int $user
 * @property string|null $thumbnail
 * @property int $is_element
 * @property int|null $element
 * @property string|null $link
 * @property string|null $content
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Highlight extends Model
{
	protected $table = 'highlights';

	protected $casts = [
		'user' => 'int',
		'is_element' => 'int',
		'element' => 'int',
		'position' => 'int'
	];
}
