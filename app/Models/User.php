<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 * 
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string $username
 * @property string|null $bio
 * @property string|null $social
 * @property string|null $background
 * @property string|null $buttons
 * @property string|null $fonts
 * @property string|null $settings
 * @property int $role
 * @property string|null $avatar
 * @property string|null $emailToken
 * @property string|null $facebook_id
 * @property string|null $google_id
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property int $status
 * @property int $hasTrial
 * @property string|null $lastActivity
 * @property string|null $lastAgent
 * @property string|null $extra
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticatable
{
	protected $table = 'users';

	protected $casts = [
		'role' => 'int',
		'status' => 'int',
		'hasTrial' => 'int'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'name',
		'email',
		'username',
		'bio',
		'social',
		'background',
		'buttons',
		'fonts',
		'settings',
		'role',
		'avatar',
		'emailToken',
		'facebook_id',
		'google_id',
		'email_verified_at',
		'password',
		'status',
		'hasTrial',
		'lastActivity',
		'lastAgent',
		'extra',
		'remember_token',
		'google2fa_secret',
		'google2fa_enabled'
	];
}
