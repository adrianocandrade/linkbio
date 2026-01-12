<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Block
 * 
 * @property int $id
 * @property int $user
 * @property string $block
 * @property string|null $title
 * @property string|null $blocks
 * @property string|null $settings
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Block extends Model
{
	protected $table = 'blocks';

	protected $casts = [
		'user' => 'int',
		'position' => 'int'
	];
}
