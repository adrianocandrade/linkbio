<?php

namespace Sandy\Blocks\booking\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
	protected $table = 'booking_services';

	protected $fillable = [
		'user',
		'workspace_id',  // ✅ Adicionar workspace_id
		'name',
		'thumbnail',
		'price',
		'settings',
		'status',
		'position',  // ✅ Adicionar position que também está sendo usada
		'duration',  // ✅ Adicionar duration que também está sendo usada
	];

	protected $casts = [
		'settings' => 'array',
		'thumbnail' => 'array',
	];
}
