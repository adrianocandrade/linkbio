<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DocsGuide
 * 
 * @property int $id
 * @property string|null $name
 * @property string|null $slug
 * @property int $status
 * @property int|null $docs_category
 * @property string|null $media
 * @property string|null $content
 * @property int $position
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class DocsGuide extends Model
{
	protected $table = 'docs_guides';

	protected $casts = [
		'status' => 'int',
		'docs_category' => 'int',
		'position' => 'int'
	];
}
