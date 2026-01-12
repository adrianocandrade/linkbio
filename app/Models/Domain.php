<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Domain
 * 
 * @property int $id
 * @property int $status
 * @property string|null $scheme
 * @property string|null $host
 * @property string|null $index_url
 * @property string|null $settings
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Domain extends Model
{
	protected $table = 'domains';

	protected $casts = [
		'user' => 'int',
		'workspace_id' => 'int',
		'status' => 'int'
	];

	protected $fillable = [
		'user',
		'workspace_id',
		'status',
		'scheme',
		'host',
		'index_url',
		'settings'
	];
	
	public function workspace() {
		return $this->belongsTo('App\Models\Workspace', 'workspace_id');
	}
	
	public function userModel() {
		return $this->belongsTo('App\User', 'user');
	}
}
