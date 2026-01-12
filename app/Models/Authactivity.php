<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Authactivity
 * 
 * @property int $id
 * @property int $user
 * @property string $type
 * @property string $message
 * @property string $ip
 * @property string $os
 * @property string $browser
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Authactivity extends Model
{
	protected $table = 'auth_activity';

	protected $casts = [
		'user' => 'int'
	];

	protected $fillable = [
		'user',
		'type',
		'message',
		'ip',
		'os',
		'browser'
	];
}
