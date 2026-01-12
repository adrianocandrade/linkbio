<?php

namespace App\Models;

use App\Models\Base\BookingService as BaseBookingService;

class BookingService extends BaseBookingService
{
	protected $fillable = [
		'user',
		'name',
		'thumbnail',
		'price',
		'duration',
		'settings',
		'status',
		'position'
	];
}
