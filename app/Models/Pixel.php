<?php

namespace App\Models;

use App\Models\Base\Pixel as BasePixel;

class Pixel extends BasePixel
{

    public function scopeActive($query){
        return $query->where('status', '=', 1);
    }

    public function scopeUser($query, $user){
        return $query->where('user', '=', $user);
    }

	protected $fillable = [
		'user',
		'name',
		'status',
		'pixel_id',
		'pixel_type'
	];
}
