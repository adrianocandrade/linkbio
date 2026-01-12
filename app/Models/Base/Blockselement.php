<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BlocksElement
 * 
 * @property int $id
 * @property int $user
 * @property int $block_id
 * @property string|null $thumbnail
 * @property int|null $is_element
 * @property int|null $element
 * @property string|null $link
 * @property string|null $content
 * @property string|null $settings
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class BlocksElement extends Model
{
	protected $table = 'blocks_element';

	protected $casts = [
		'user' => 'int',
		'block_id' => 'int',
		'is_element' => 'int',
		'element' => 'int',
		'position' => 'int'
	];
}
