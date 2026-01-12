<?php

namespace Sandy\Blocks\booking\Models;

use Illuminate\Database\Eloquent\Model;

class BookingOrder extends Model
{
	protected $appends = ['status_html'];
	protected $table = 'booking_orders';

	protected $fillable = [
		'user',
		'payee_user_id',
		'details',
		'currency',
		'email',
		'ref',
		'price',
		'is_deal',
		'deal_discount',
		'products',
		'extra',
		'status'
	];


	protected $casts = [
		'details' => 'array',
		'extra' => 'array'
	];

	public function getStatusHtmlAttribute(){
		$html = '';
		$classes = 'text-xs font-bold tag';
		switch ($this->status) {
			case 0:
				$html = 'Pending';
				$classes .= ' bg-yellow-400';
			break;

			case 1:
				$html = 'Paid';
			break;

			case 2:
				$html = 'Failed';
				$classes .= ' bg-red-400 text-white';
			break;
		}

		$html = "<span class=\"$classes\">". __($html) ."</span>";
		return $html;
	}
}
