<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Page
 * 
 * @property int $id
 * @property string|null $category
 * @property string $url
 * @property string|null $title
 * @property string $status
 * @property string $type
 * @property string|null $image
 * @property string|null $settings
 * @property int $order
 * @property int $total_views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Page extends Model
{
	protected $table = 'pages';

	protected $casts = [
		'order' => 'int',
		'total_views' => 'int'
	];

	protected $fillable = [
		'category',
		'url',
		'title',
		'status',
		'type',
		'image',
		'settings',
		'order',
		'total_views'
	];
}
