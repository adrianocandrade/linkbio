<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Blog
 * 
 * @property int $id
 * @property string $location
 * @property int|null $postedBy
 * @property string|null $name
 * @property string $status
 * @property string $type
 * @property string|null $thumbnail
 * @property string|null $description
 * @property string|null $settings
 * @property string|null $author
 * @property string|null $ttr
 * @property int $position
 * @property int $total_views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class Blog extends Model
{
	protected $table = 'blog';

	protected $casts = [
		'postedBy' => 'int',
		'position' => 'int',
		'total_views' => 'int'
	];
}
