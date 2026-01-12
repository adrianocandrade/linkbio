<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocsCategory
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property string|null $media
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class DocsCategory extends Model
{
	protected $table = 'docs_categories';

	protected $casts = [
		'position' => 'int'
	];
}
