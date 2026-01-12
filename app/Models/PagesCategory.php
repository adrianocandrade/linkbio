<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PagesCategory
 * 
 * @property int $id
 * @property string $url
 * @property int $status
 * @property string|null $title
 * @property string|null $description
 * @property string|null $icon
 * @property int $order
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class PagesCategory extends Model
{
	protected $table = 'pages_categories';

	protected $casts = [
		'status' => 'int',
		'order' => 'int'
	];

	protected $fillable = [
		'url',
		'status',
		'title',
		'description',
		'icon',
		'order'
	];
}
