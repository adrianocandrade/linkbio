<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class YettiBlock
 * 
 * @property int $id
 * @property int $user
 * @property string $block
 * @property string|null $title
 * @property string|null $blocks
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class YettiBlock extends Model
{
	protected $table = 'blocks';

	protected $casts = [
		'user' => 'int',
		'position' => 'int'
	];
}
