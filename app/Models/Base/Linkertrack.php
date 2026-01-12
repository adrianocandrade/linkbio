<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class LinkerTrack
 * 
 * @property int $id
 * @property int|null $linker
 * @property int|null $user
 * @property string|null $session
 * @property string|null $link
 * @property string|null $slug
 * @property string|null $ip
 * @property string|null $tracking
 * @property int $views
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class LinkerTrack extends Model
{
	protected $table = 'linker_track';

	protected $casts = [
		'linker' => 'int',
		'user' => 'int',
		'views' => 'int'
	];
}
