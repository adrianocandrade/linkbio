<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

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
 * @property string|null $booking
 * @property string|null $background_settings
 * @property string|null $buttons
 * @property string|null $font
 * @property string|null $theme
 * @property string|null $color
 * @property string|null $settings
 * @property string|null $integrations
 * @property string|null $store
 * @property string|null $payments
 * @property string|null $seo
 * @property string|null $pwa
 * @property int $role
 * @property string|null $avatar
 * @property string|null $avatar_settings
 * @property string|null $emailToken
 * @property string|null $facebook_id
 * @property string|null $google_id
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property int $status
 * @property int $hasTrial
 * @property string|null $lastActivity
 * @property string|null $lastAgent
 * @property string|null $lastCountry
 * @property string|null $phone_number
 * @property string|null $api
 * @property string|null $extra
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models\Base
 */
class User extends Model
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
}
