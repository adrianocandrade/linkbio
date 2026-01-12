<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class YettiBlocksSection
 * 
 * @property int $id
 * @property int $user
 * @property int $block_id
 * @property string|null $thumbnail
 * @property string|null $content
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class YettiBlocksSection extends Model
{
	protected $table = 'blocks_element';

	protected $casts = [
		'user' => 'int',
		'block_id' => 'int',
		'position' => 'int'
	];
}
