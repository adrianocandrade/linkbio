<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class SandyEmbedStore
 * 
 * @property int $id
 * @property string|null $link
 * @property string|null $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class SandyEmbedStore extends Model
{
	protected $table = 'sandy_embed_store';
}
