<?php

namespace App\Models;

use App\Models\Base\UserUploadPath as BaseUserUploadPath;

class UserUploadPath extends BaseUserUploadPath
{
	protected $fillable = [
		'user',
		'path'
	];
}
