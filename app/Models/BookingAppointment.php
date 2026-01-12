<?php

namespace App\Models;

use App\Models\Base\BookingAppointment as BaseBookingAppointment;

class BookingAppointment extends BaseBookingAppointment
{
	protected $fillable = [
		'user',
		'payee_user_id',
		'service_ids',
		'date',
		'time',
		'settings',
		'info',
		'appointment_status',
		'price',
		'is_paid'
	];
}
